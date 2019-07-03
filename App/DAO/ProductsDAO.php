<?php

namespace App\DAO;

use App\Models\ProductsModel;

class ProductsDAO extends Connection
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProducts(): array
    {
        $products = $this->pdo
            ->query('SELECT `products`.*, `categories`.`name` as category FROM `products` INNER JOIN categories ON products.category_id = categories.id')
            ->fetchAll(\PDO::FETCH_ASSOC);

        return $products;
    }

    public function getByID($id): array
    {
        $products = $this->pdo
            ->query("SELECT `products`.*, `categories`.`name` as category FROM `products` INNER JOIN categories ON products.category_id = categories.id WHERE `products`.id = $id")
            ->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }

    public function insertProduct(ProductsModel $products): void
    {

        $statemant = $this->pdo
            ->prepare('INSERT INTO products (`name`,`stock`,`image`,`value`,`unity`,`date`,`status`,`category_id`) 
                VALUES(:name, :stock, :image, :value, :unity, NOW(), :status, :category)');
        $statemant->execute([
            'name' => $products->getName(),
            'stock' => $products->getStock(),
            'image' => $products->getImage(),
            'value' => $products->getValue(),
            'unity' => $products->getUnity(),
            'status' => $products->getStatus(),
            'category' => $products->getCategory(),
        ]);
    }

    public function updateProduct($id, ProductsModel $products): void
    {

        $statemant = $this->pdo
            ->prepare('UPDATE products SET  `name` = :name , `image` = :image ,`value` = :value,
                `unity` = :unity,`status` = :status,`category_id` = :category WHERE id = :id');
        $statemant->execute([
            'id' => $id,
            'name' => $products->getName(),
            'image' => $products->getImage(),
            'value' => $products->getValue(),
            'unity' => $products->getUnity(),
            'status' => $products->getStatus(),
            'category' => $products->getCategory(),
        ]);
    }

    public function updateStock($id): void
    {
        $statemant = $this->pdo
            ->prepare('UPDATE products
                SET stock = (SELECT SUM(quantity) FROM inventories WHERE product_id = :id)
                WHERE id = :id');
        $statemant->execute([
            'id' => $id,
        ]);
    }

    public function deleteProduct($id): void
    {

        $statemant = $this->pdo
            ->prepare('DELETE FROM `products` WHERE id = :id');
        $statemant->execute([
            'id' => $id,
        ]);
    }
}
