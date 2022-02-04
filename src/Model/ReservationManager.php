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
    
    public function selectAllOrdered()
    {
        $sql = "SELECT u.firstname, u.lastname, u.email, u.adress, u.phone, c.name, c.plate 
        FROM reservation r
        JOIN user u ON r.customer_id = u.id
        JOIN car c ON r.car_id = c.id";
        return $this->pdo->query($sql)->fetchAll();
    }
}
