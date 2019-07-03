<?php

namespace App\DAO;

use App\Models\StoresModel;

class StoresDAO extends Connection {

    public function __construct()
    {
        parent::__construct();      
    }

    public function getAllStores() : array {
        $stores = $this->pdo
        ->query('SELECT * FROM `stores`')
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $stores;

    }

    public function insertStore(StoresModel $stores) : void {

        $statemant = $this->pdo
            ->prepare('INSERT INTO stores (`name`) VALUES(:name )');
        $statemant->execute([
            'name' => $stores->getName()
        ]);    

    }
    public function updateStore($id, StoresModel $stores) : void {

        $statemant = $this->pdo
            ->prepare('UPDATE `stores` SET `name`= :name WHERE id = :id');
        $statemant->execute([
            'id' => $id,
            'name' => $stores->getName()
        ]);    

    }

    public function deleteStore($id) : void {

        $statemant = $this->pdo
            ->prepare('DELETE FROM `stores` WHERE id = :id');
        $statemant->execute([
            'id' => $id,
        ]);
    }
}