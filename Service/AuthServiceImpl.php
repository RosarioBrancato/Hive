<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 08.10.2017
 * Time: 14:39
 */

namespace Service;

use DTO\Agent;
use DTO\AuthToken;
use Http\HTTPException;
use Http\HTTPStatusCode;
use Model\AgentModel;
use Model\AuthTokenModel;

/**
 * @access public
 * @author andreas.martin
 */
class AuthServiceImpl implements AuthService
{
    /**
     * @AttributeType AuthServiceImpl
     */
    private static $instance = null;
    /**
     * @AttributeType int
     */
    private $currentAgentId;

    /**
     * @var string
     */
    private $currentAgentName;

    /**
     * @var string
     */
    private $currentAgentTimezone;

    /**
     * @access public
     * @return AuthServiceImpl
     * @static
     * @ReturnType AuthServiceImpl
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @access protected
     */
    protected function __construct()
    {
    }

    /**
     * @access private
     */
    private function __clone()
    {
    }

    /**
     * @access public
     * @return boolean
     * @ReturnType boolean
     */
    public function verifyAuth()
    {
        $verified = false;

        if (isset($this->currentAgentId)) {
            $verified = true;
        }

        return $verified;
    }

    /**
     * @access public
     * @return int
     * @ReturnType int
     */
    public function getCurrentAgentId()
    {
        return $this->currentAgentId;
    }

    public function getCurrentAgentName()
    {
        return $this->currentAgentName;
    }

    public function getCurrentAgentTimezone()
    {
        return $this->currentAgentTimezone;
    }

    /**
     * @access public
     * @param String email
     * @param String password
     * @return Agent
     * @ParamType email String
     * @ParamType password String
     * @ReturnType boolean
     */
    public function verifyAgent($email, $password)
    {
        $agentModel = new AgentModel();
        $agent = $agentModel->findByEmail($email);
        if (isset($agent)) {

            if (password_verify($password, $agent->getPassword())) {
                if (password_needs_rehash($agent->getPassword(), PASSWORD_DEFAULT)) {
                    $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
                    $agentModel->update($agent);
                }
                $this->currentAgentId = $agent->getId();
                $this->currentAgentName = $agent->getName();
                $this->currentAgentTimezone = $agent->getTimezone();
            }
        }

        return $agent;
    }

    /**
     * @access public
     * @return Agent
     * @ReturnType Agent
     * @throws HTTPException
     */
    public function readAgent()
    {
        if ($this->verifyAuth()) {
            $agentModel = new AgentModel();
            return $agentModel->read($this->currentAgentId);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    /**
     * @access public
     * @param string name
     * @param String email
     * @param String password
     * @param String timezone
     * @return boolean
     * @ParamType name string
     * @ParamType email String
     * @ParamType password String
     * @ParamType timezone String
     * @ReturnType boolean
     */
    public function editAgent($name, $email, $password, $timezone)
    {
        $agent = new Agent();
        $agent->setName($name);
        $agent->setEmail($email);
        $agent->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $agent->setTimezone($timezone);
        $agentModel = new AgentModel();
        if ($this->verifyAuth()) {
            $agent->setId($this->currentAgentId);
            if ($agentModel->read($this->currentAgentId)->getEmail() !== $agent->getEmail()) {
                if (!is_null($agentModel->findByEmail($email))) {
                    return false;
                }
            }
            $agentModel->update($agent);
            return true;
        } else {
            if (!is_null($agentModel->findByEmail($email))) {
                return false;
            }
            $agentModel->create($agent);
            return true;
        }
    }

    /**
     * @access public
     * @param String token
     * @return boolean
     * @ParamType token String
     * @ReturnType boolean
     * @throws \Exception
     */
    public function validateToken($token)
    {
        $tokenArray = explode(":", $token);
        $authTokenModel = new AuthTokenModel();
        $authToken = $authTokenModel->findBySelector($tokenArray[0]);
        if (!empty($authToken)) {
            if (time() <= (new \DateTime($authToken->getExpiration()))->getTimestamp()) {
                if (hash_equals(hash('sha384', hex2bin($tokenArray[1])), $authToken->getValidator())) {
                    $this->currentAgentId = $authToken->getAgentid();

                    $agentModel = new AgentModel();
                    $agent = $agentModel->read($this->currentAgentId);
                    $this->currentAgentName = $agent->getName();
                    $this->currentAgentTimezone = $agent->getTimezone();

                    if ($authToken->getType() === self::RESET_TOKEN) {
                        $authTokenModel->delete($authToken);
                    }
                    return true;
                }
            }
            $authTokenModel->delete($authToken);
        }
        return false;
    }

    /**
     * @access public
     * @param int type
     * @param String email
     * @return String
     * @ParamType type int
     * @ParamType email String
     * @ReturnType String
     * @throws HTTPException
     *
     * https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
     * https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#Authentication
     * https://stackoverflow.com/a/31419246
     */
    public function issueToken($type = self::AGENT_TOKEN, $email = null)
    {
        $token = new AuthToken();
        $token->setSelector(bin2hex(random_bytes(5)));

        if ($type === self::AGENT_TOKEN) {
            $token->setType(self::AGENT_TOKEN);
            $token->setAgentid($this->currentAgentId);
            $timestamp = (new \DateTime('now'))->modify('+30 days');

        } elseif (isset($email)) {
            $token->setType(self::RESET_TOKEN);
            $token->setAgentid((new AgentModel())->findByEmail($email)->getId());
            $timestamp = (new \DateTime('now'))->modify('+1 hour');

        } else {
            throw new HTTPException(HTTPStatusCode::HTTP_406_NOT_ACCEPTABLE, 'RESET_TOKEN without email');
        }

        $token->setExpiration($timestamp->format("Y-m-d H:i:s"));
        $validator = random_bytes(20);
        $token->setValidator(hash('sha384', $validator));

        $authTokenModel = new AuthTokenModel();
        $authTokenModel->create($token);

        return $token->getSelector() . ":" . bin2hex($validator);
    }

    public function destroySession()
    {
        $this->currentAgentId = null;
        $this->currentAgentName = null;
        $this->currentAgentTimezone = null;
    }
}