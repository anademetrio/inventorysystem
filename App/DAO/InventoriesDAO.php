<?php

namespace App\DAO;

use src\appFunctions;
use App\Models\InventoriesModel;

class InventoriesDAO extends Connection {

    protected $fn;
    protected $productDAO;

    public function __construct()
    {
        parent::__construct();  
        
        $this->fn = new appFunctions();
        $this->productDAO = new ProductsDAO();
    }
    public function getAllInventories() : array {
        $inventories = $this->pdo
        ->query('SELECT `inventories`.*, `products`.`name`  as product, stores.name as store FROM `inventories` 
            INNER JOIN products ON products.id = inventories.product_id
            INNER JOIN stores ON inventories.store_id = stores.id')
        ->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($inventories as $row) {
            $data[] = [
                "id"                    => $row['id'],
                "quantity"              => $row['quantity'],
                "type"                  => $row['type'],
                "date"                  => $this->fn->setDateToBR($row['date']),
                "detail"                => $row['detail'],
                "product_id"            => $row['product_id'],
                "store_id"              => $row['store_id'],
                "transfer_id"           => $row['transfer_id'],
                "product"               => $row['product'],
                "store"                 => $row['store'],

            ];
        }

        return $data;

        //return $inventories;

    }

    public function getByID($id) : array {
        $products = $this->pdo
        ->query("SELECT `inventories`.*, `products`.`name`  as product, stores.name as store FROM `inventories` 
            INNER JOIN products ON products.id = inventories.product_id
            INNER JOIN stores ON inventories.store_id = stores.id 
            WHERE `inventories`.id = $id")
        ->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }

    public function getInventoryStock($id) : array {
        $inventories = $this->pdo
        ->query("SELECT
            SUM(quantity) as quantity, products.name as product, stores.name as store, product_id, store_id
            FROM
                inventories
            INNER JOIN products ON products.id = inventories.product_id
            INNER JOIN stores ON inventories.store_id = stores.id    
            WHERE product_id = $id
            GROUP BY store_id")
        ->fetchAll(\PDO::FETCH_ASSOC);

        return $inventories;

    }

    public function getInventoryStoreStock($product_id, $store_id) : array {
        $inventories = $this->pdo
        ->query("SELECT
            SUM(quantity) as quantity, products.name as product, stores.name as store, product_id, store_id
            FROM
                inventories
            INNER JOIN products ON products.id = inventories.product_id
            INNER JOIN stores ON inventories.store_id = stores.id    
            WHERE product_id = $product_id AND store_id = $store_id")
        ->fetchAll(\PDO::FETCH_ASSOC);



        return $inventories;

    }

    public function insertInventory(InventoriesModel $inventories) : void {

        if($inventories->getType() == 0) {
            $quantity = $inventories->getQuantity() *-1;
        } else {
            $quantity = $inventories->getQuantity();
        }

        $statemant = $this->pdo
            ->prepare('INSERT INTO inventories (`quantity`,`type`,`date`,`detail`,`product_id`,`store_id`,`transfer_id`) 
                VALUES(:quantity, :type, NOW(), :detail, :product, :store, :transfer)');
        $statemant->execute([
            'quantity' => $quantity,
            'type' => $inventories->getType(),
            'detail' => $inventories->getDetail(), 
            'product' => $inventories->getProduct(),
            'store' => $inventories->getStore(),
            'transfer' => $inventories->getTransfer()
        ]);  
        
        $this->productDAO->updateStock($inventories->getProduct());

    }

    public function updateInventory($id, InventoriesModel $inventories) : void {

        $statemant = $this->pdo
            ->prepare('UPDATE inventories SET  `type` = :type WHERE id = :id');
        $statemant->execute([
            'id' => $id,
            'type' => $inventories->getType(),
        ]);    

    }

    public function deleteInventory($id, $product_id) : void {   
        $statemant = $this->pdo
            ->prepare('DELETE FROM `inventories` WHERE id = :id');
        $statemant->execute([
            'id' => $id
        ]);

        $this->productDAO->updateStock($product_id);
    }
}