<?php

namespace App\DAO;

use App\Models\CategoriesModel;

class CategoriesDAO extends Connection {

    public function __construct()
    {
        parent::__construct();       
    }
    public function getAllCategories() : array {
        $categories = $this->pdo
        ->query('SELECT * FROM `categories`')
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $categories;

    }

    public function insertCategory(CategoriesModel $categories) : void {

        $statemant = $this->pdo
            ->prepare('INSERT INTO categories (`name`, `status`) VALUES(:name, :status)');
        $statemant->execute([
            'name' => $categories->getName(),
            'status' => $categories->getStatus()
        ]);    

    }
    public function updateCategory($id, CategoriesModel $categories) : void {

        $statemant = $this->pdo
            ->prepare('UPDATE `categories` SET `name`= :name, `status` = :status WHERE id = :id');
        $statemant->execute([
            'id' => $id,
            'name' => $categories->getName(),
            'status' => $categories->getStatus()
        ]);    

    }

    public function deleteCategory($id) : void {

        $statemant = $this->pdo
            ->prepare('DELETE FROM `categories` WHERE id = :id');
        $statemant->execute([
            'id' => $id,
        ]);
    }
}