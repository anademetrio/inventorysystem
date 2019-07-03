<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\TransfersDAO;
use App\Models\TransfersModel;

final class TransferController {

    protected $DAO;
    protected $model;

    public function __construct()
    {
        $this->DAO = new TransfersDAO();
        $this->model = new TransfersModel();
    }

    public function getTranfers(Request $request, Response $response, array $args ) : Response {
        
        $stores = $this->DAO->getAllTransfers();

        $response = $response->withJson($stores);

        return $response;

    }
    public function insertTranfer(Request $request, Response $response, array $args ) : Response {
        
        $data = $request->getParsedBody();

        $transfer = $this->model->setQuantity($data['quantity'])
                ->setProduct($data['product'])
                ->setStoreOrigin($data['store_origin'])
                ->setStoreDestiny($data['store_destiny']);


        $result = $this->DAO->insertTransfer($transfer);

        $response = $response->withJson([
            'response' => $result
        ]);

        return $response;
    }
    public function updateTranfer(Request $request, Response $response, array $args ) : Response {
        return $response;
    }
    public function deleteTranfer(Request $request, Response $response, array $args ) : Response {
        
        $id = $args['id'];

        $this->DAO->deleteTranfer($id);

        $response = $response->withJson([
            'msg' => 'Movimento deletado com sucesso! '
        ]);

        return $response;
    }
}