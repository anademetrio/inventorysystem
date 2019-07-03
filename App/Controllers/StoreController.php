<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\StoresDAO;
use App\Models\StoresModel;

final class StoreController {
    

    protected $DAO;
    protected $model;

    public function __construct()
    {
        $this->DAO = new StoresDAO();
        $this->model = new StoresModel();
    }

    public function getStores(Request $request, Response $response, array $args ) : Response {

        $stores = $this->DAO->getAllStores();

        $response = $response->withJson($stores);

        return $response;
    }

    public function insertStore(Request $request, Response $response, array $args ) : Response {

        $data = $request->getParsedBody();

        $store = $this->model->setName($data['name']);


        $this->DAO->insertStore($store);

        $response = $response->withJson([
            'msg' => 'Loja inserida com sucesso!'
        ]);
        return $response;
    }
    public function updateStore(Request $request, Response $response, array $args ) : Response {
        
        $data = $request->getParsedBody();
        $id = $args['id'];

        $store = $this->model->setName($data['name']);


        $this->DAO->updateStore($id, $store);

        $response = $response->withJson([
            'msg' => 'Loja atualizada com sucesso! '
        ]);

        return $response;
    }
    public function deleteStore(Request $request, Response $response, array $args ) : Response {

        $id = $args['id'];

        $this->DAO->deleteStore($id);

        $response = $response->withJson([
            'msg' => 'Loja deletada com sucesso! '.$id
        ]);

        return $response;
    }
}