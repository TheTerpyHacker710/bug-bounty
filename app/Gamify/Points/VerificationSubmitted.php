<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class VerificationSubmitted extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 100;

    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * User who will be receive points
     *
     * @return mixed
     */
    public function payee()
    {
        return $this->getSubject()->user;
    }
}
