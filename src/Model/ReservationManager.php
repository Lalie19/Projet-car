<?php

namespace App\Model;

class ReservationManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'reservation';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
}
