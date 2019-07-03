<?php

namespace App\DAO;

use src\appFunctions;
use App\Models\TransfersModel;
use App\Models\InventoriesModel;

class TransfersDAO extends Connection
{

    protected $fn;
    protected $inventoryDAO;
    protected $inventoryModel;

    public function __construct()
    {
        parent::__construct();

        $this->fn = new appFunctions();
        $this->inventoryDAO = new InventoriesDAO();
        $this->inventoryModel = new InventoriesModel();
    }

    public function getAllTransfers(): array
    {
        $transfers = $this->pdo
            ->query('SELECT transfers.id, transfers.quantity, transfers.date, products.name as product, o.name as store_origin, d.name as store_destiny FROM `transfers` 
                        INNER JOIN products ON products.id = transfers.product_id
                        INNER JOIN stores o ON transfers.store_origin_id = o.id
                        INNER JOIN stores d ON transfers.store_destiny_id = d.id')
            ->fetchAll(\PDO::FETCH_ASSOC);

        $data = [];
        foreach ($transfers as $row) {
            $data[] = [
                "id"                => $row['id'],
                "quantity"          => $row['quantity'],
                "date"              => $this->fn->setDateToBR($row['date']),
                "product"           => $row['product'],
                "store_origin"      => $row['store_origin'],
                "store_destiny"     => $row['store_destiny']
            ];
        }

        return $data;
    }

    public function insertTransfer(TransfersModel $transfers)
    {

        $stockOrg = $this->inventoryDAO->getInventoryStoreStock($transfers->getProduct(), $transfers->getStoreOrigin());

        $data = [];

        if ($transfers->getQuantity() > $stockOrg[0]['quantity']) {
            $data[] = [
                "success" => false,
                "msg" => "O armazém " . $stockOrg[0]['store'] . " não tem estoque 
                            suficiente para realizar a transferencia"
            ];
        } else {
            $statemant = $this->pdo
                ->prepare('INSERT INTO transfers (`quantity`,`date`,`product_id`,`store_origin_id`,`store_destiny_id`) 
            VALUES(:quantity, NOW(), :product, :store_origin, :store_destiny)');

            $statemant->execute([
                'quantity' => $transfers->getQuantity(),
                'product' => $transfers->getProduct(),
                'store_origin' => $transfers->getStoreOrigin(),
                'store_destiny' => $transfers->getStoreDestiny(),
            ]);

            $dataEntry = $this->inventoryModel
                ->setQuantity($transfers->getQuantity())
                ->setType(1)
                ->setDetail('Transferencia de entrada')
                ->setProduct($transfers->getProduct())
                ->setStore($transfers->getStoreDestiny())
                ->setTransfer($this->pdo->lastInsertId());

            $this->inventoryDAO->insertInventory($dataEntry);

            $dataExit = $this->inventoryModel
                ->setQuantity($transfers->getQuantity())
                ->setType(0)
                ->setDetail('Transferencia de saída')
                ->setProduct($transfers->getProduct())
                ->setStore($transfers->getStoreOrigin())
                ->setTransfer($this->pdo->lastInsertId());

            $this->inventoryDAO->insertInventory($dataExit);

            $data[] = [
                "success" => true,
                "msg" => "O produto foi movido com sucesso!"
            ];
        }

        return $data;
    }
    public function updateTransfer($id, TransfersModel $transfers): void
    { }

    public function deleteTransfer($id): void
    {

        $statemant = $this->pdo
            ->prepare('DELETE FROM `transfers` WHERE id = :id');
        $statemant->execute([
            'id' => $id,
        ]);
    }
}
