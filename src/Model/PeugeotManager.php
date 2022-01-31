<?php

namespace App\Model;

class PeugeotManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'car';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $sql = 'SELECT brand FROM car WHERE brand LIKE "peug%"';
        parent::__construct(self::TABLE);
        

    }
    
}
