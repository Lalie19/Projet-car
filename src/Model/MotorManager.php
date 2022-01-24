<?php

namespace App\Model;

class MotorManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'motor';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
}
