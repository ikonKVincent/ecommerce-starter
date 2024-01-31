<?php

namespace App\Exceptions;

use Exception;

class TooManyRequestException extends Exception
{
    public $component;

    public $ip;

    public $method;

    public $minutesUntilAvailable;

    public $secondsUntilAvailable;

    public function __construct($component, $method, $ip, $secondsUntilAvailable)
    {
        $this->component = $component;
        $this->ip = $ip;
        $this->method = $method;
        $this->secondsUntilAvailable = $secondsUntilAvailable;

        $this->minutesUntilAvailable = ceil($this->secondsUntilAvailable / 60);

        parent::__construct(sprintf(
            'Nous sommes désolés, vous avez dépassé le nombre maximum de tentatives. Par mesure de sécurité, veuillez recommencer dans %d %e.',
            $this->ip,
            $this->method,
            $this->component,
            $this->minutesUntilAvailable > 1 ? $this->minutesUntilAvailable : $this->secondsUntilAvailable,
            $this->minutesUntilAvailable > 1 ? 'minutes' : 'secondes',
        ));
    }
}
