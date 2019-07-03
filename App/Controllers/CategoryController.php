<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use App\DAO\CategoriesDAO;
use App\Models\CategoriesModel;


final class CategoryController {

    protected $DAO; 
    protected $model;

    public function __construct()
    {
       $this->DAO = new CategoriesDAO();
       $this->model = new CategoriesModel();
    }

    public function getCategories(Request $request, Response $response, array $args ) : Response {

        $categories = $this->DAO->getAllCategories();

        $response = $response->withJson($categories);


        return $response;
    }
    public function insertCategory(Request $request, Response $response, array $args ) : Response {

        $data = $request->getParsedBody();

        
        $category = $this->model->setName($data['name'])->setStatus($data['status']);


        $this->DAO->insertCategory($category);

        $response = $response->withJson([
            'msg' => 'Categoria inserida com sucesso!'
        ]);

        return $response;
    }
    public function updateCategory(Request $request, Response $response, array $args ) : Response {

        $data = $request->getParsedBody();
        $id = $args['id'];

        $category = $this->model->setName($data['name'])->setStatus($data['status']);


        $this->DAO->updateCategory($id, $category);

        $response = $response->withJson([
            'msg' => 'Categoria atualizada com sucesso! '
        ]);

        return $response;
    }
    public function deleteCategory(Request $request, Response $response, array $args ) : Response {
        
        $id = $args['id'];

        $this->DAO->deleteCategory($id);

        $response = $response->withJson([
            'msg' => 'Categoria deletada com sucesso! '.$id
        ]);

        return $response;
    }
}