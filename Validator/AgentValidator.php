<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 11.10.2017
 * Time: 11:27
 */

namespace Validator;

use DTO\Agent;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;

class AgentValidator
{
    private $valid = true;

    private $nameError = null;
    private $emailError = null;
    private $passwordError = null;
    private $timezoneError = null;

    public function __construct(Agent $agent = null)
    {
        if (!is_null($agent)) {
            $this->validate($agent);
        }
    }

    public function validate(Agent $agent)
    {
        if (!is_null($agent)) {
            if (empty($agent->getName())) {
                $this->nameError = 'Please enter a name';
                $this->valid = false;
            }

            if (empty($agent->getEmail())) {
                $this->emailError = 'Please enter an email address';
                $this->valid = false;
            } else if (!filter_var($agent->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $this->emailError = 'Please enter a valid email address';
                $this->valid = false;
            }

            if (empty($agent->getPassword())) {
                $this->passwordError = 'Please enter a password';
                $this->valid = false;
            }

            if (empty($agent->getTimezone())) {
                $this->timezoneError = 'Please select a timezone';
                $this->valid = false;
            }
        } else {
            $this->valid = false;
        }

        return $this->valid;
    }

    public function validateAttributes(Agent $agent)
    {
        $isOk = true;

        if (empty($agent->getName())) {
            $isOk = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, 'Please enter a name');
        }

        if (empty($agent->getEmail())) {
            $isOk = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, 'Please enter an email address');
        } else if (!filter_var($agent->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $isOk = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, 'Please enter an email address');
        }

        if (empty($agent->getTimezone())) {
            $isOk = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, 'Please select a timezone');
        }

        return $isOk;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function isNameError()
    {
        return isset($this->nameError);
    }

    public function getNameError()
    {
        return $this->nameError;
    }

    public function isEmailError()
    {
        return isset($this->emailError);
    }

    public function getEmailError()
    {
        return $this->emailError;
    }

    public function setEmailError($emailError)
    {
        $this->emailError = $emailError;
        $this->valid = false;
    }

    public function isPasswordError()
    {
        return isset($this->passwordError);
    }

    public function getPasswordError()
    {
        return $this->passwordError;
    }

    public function isTimezoneError()
    {
        return isset($this->timezoneError);
    }

    public function getTimezoneError()
    {
        return $this->timezoneError;
    }
}