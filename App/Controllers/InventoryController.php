<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\InventoriesDAO;
use App\Models\InventoriesModel;

final class InventoryController {

    protected $DAO; 
    protected $model;

    public function __construct()
    {
       $this->DAO = new InventoriesDAO();
       $this->model = new InventoriesModel();
    }

    public function getInventories(Request $request, Response $response, array $args ) : Response {
        $inventories = $this->DAO->getAllInventories();

        $response = $response->withJson($inventories);


        return $response;
    }

    public function getInventoryStock(Request $request, Response $response, array $args) : Response {

        $id = $args['id'];

        $inventories = $this->DAO->getInventoryStock($id);

        $response = $response->withJson($inventories);

        return $response;
    }

    public function getInventoryStoreStock(Request $request, Response $response, array $args) : Response {
        
        $product_id = $args['product_id'];
        $store_id = $args['store_id'];
        
        $inventories = $this->DAO->getInventoryStoreStock($product_id, $store_id);

        $response = $response->withJson($inventories);

        return $response;
    }

    public function insertInventory(Request $request, Response $response, array $args ) : Response {

        $data = $request->getParsedBody();

        
        $inventory = $this->model
            ->setQuantity($data['quantity'])
            ->setType($data['type'])
            ->setDetail($data['detail'])
            ->setProduct($data['product'])
            ->setStore($data['store'])
            ->setTransfer($data['transfer']);


        $this->DAO->insertInventory($inventory);

        $response = $response->withJson([
            'msg' => 'Inventorio inserido com sucesso!'
        ]);

        return $response;
    }
    public function updateInventory(Request $request, Response $response, array $args ) : Response {
        $data = $request->getParsedBody();
        $id = $args['id'];

        $inventory = $this->model->setType($data['type']);


        $this->DAO->updateInventory($id, $inventory);

        $response = $response->withJson([
            'msg' => 'Inventorio atualizado com sucesso! '
        ]);

        return $response;
    }
    public function deleteInventory(Request $request, Response $response, array $args ) : Response {

        $data = $request->getParsedBody();

        $id = $args['id'];
        $product_id = $args['product_id'];


        $this->DAO->deleteInventory($id, $product_id);

        $response = $response->withJson([
            'msg' => 'Inventorio deletado com sucesso! '
        ]);

        return $response;
    }
}