<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\ProductsDAO;
use App\Models\ProductsModel;


final class ProductController {

    protected $DAO;
    protected $model;

    public function __construct()
    {
        $this->DAO = new ProductsDAO();
        $this->model = new ProductsModel();
    }

    public function getProducts(Request $request, Response $response, array $args ) : Response {

        $products = $this->DAO->getAllProducts();

        $response = $response->withJson($products);

        return $response;
    }

    public function getByID(Request $request, Response $response, array $args ) : Response {

        $id = $args['id'];

        $products = $this->DAO->getByID($id);

        $response = $response->withJson($products);

        return $response;
    }

    public function insertProduct(Request $request, Response $response, array $args ) : Response {
        $data = $request->getParsedBody();

        $product = $this->model->setName($data['name'])
            ->setStock($data['stock'])
            ->setImage($data['image'])
            ->setUnity($data['unity'])
            ->setValue($data['value'])
            ->setStatus($data['status'])
            ->setCategory($data['category']);


        $this->DAO->insertProduct($product);

        $response = $response->withJson([
            'msg' => 'Produto inserido com sucesso!'
        ]);
        return $response;
    }
    public function updateProduct(Request $request, Response $response, array $args ) : Response {
        $data = $request->getParsedBody();
        $id = $args['id'];

        $product = $this->model->setName($data['name'])
            ->setImage($data['image'])
            ->setUnity($data['unity'])
            ->setValue($data['value'])
            ->setStatus($data['status'])
            ->setCategory($data['category']);



        $this->DAO->updateProduct($id, $product);

        $response = $response->withJson([
            'msg' => 'Produto atualizado com sucesso! '
        ]);

        return $response;
    }
    public function deleteProduct(Request $request, Response $response, array $args ) : Response {

        $id = $args['id'];
        
        $this->DAO->deleteProduct($id);

        $response = $response->withJson([
            'msg' => 'Produto deletado com sucesso! '
        ]);

        return $response;
    }
}