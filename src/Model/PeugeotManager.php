<?php

namespace App\Model;

class PeugeotManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'car WHERE brand LIKE "peug%"';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
        

    }
    public function selectAllOrdered()
    {
        $sql = "SELECT m.category_flue, t.category, s.available, s.lieu 
        FROM car p
        JOIN motor m ON p.motor_id = m.id
        JOIN type t ON p.type_id = t.id
        JOIN status s ON p.status_id = s.id";
        return $this->pdo->query($sql)->fetchAll();
    }
}

