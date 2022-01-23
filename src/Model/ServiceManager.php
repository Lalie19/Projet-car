<?php

namespace App\Model;

class ServiceManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'service';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
}
