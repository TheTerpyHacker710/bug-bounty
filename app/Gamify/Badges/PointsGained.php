<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class PointsGained extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'First points recieved';
    
    protected $level = 1;

    protected $icon = 'storage/badges/first-report.svg';

    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->getPoints() >= 100;
    }
}
