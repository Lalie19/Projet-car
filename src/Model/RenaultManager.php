<?php

namespace App\Model;

class RenaultManager extends AbstractManager
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
        parent::__construct(self::TABLE);

    }
    
}
