<?php

namespace DTO;

/**
 * @access private
 * @author andreas.martin
 */
class Agent {
	/**
	 * @AttributeType int
	 */
	private $id;
	/**
	 * @AttributeType String
	 */
	private $name;
	/**
	 * @AttributeType String
	 */
	private $email;
    /**
     * @AttributeType String
     */
    private $timezone;
	/**
	 * @AttributeType String
	 */
	private $password;

	/**
	 * @access public
	 * @return int
	 * @ReturnType int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @access public
	 * @param int id
	 * @return void
	 * @ParamType id int
	 * @ReturnType void
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @access public
	 * @param String name
	 * @return void
	 * @ParamType name String
	 * @ReturnType void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @access public
	 * @param String email
	 * @return void
	 * @ParamType email String
	 * @ReturnType void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @access public
	 * @return String
	 * @ReturnType String
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @access public
	 * @param String password
	 * @return void
	 * @ParamType password String
	 * @ReturnType void
	 */
	public function setPassword($password) {
		$this->password = $password;
	}
    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

}
?>