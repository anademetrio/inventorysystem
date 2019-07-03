<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\UsersDAO;
use App\Models\UsersModel;

final class UserController {

    protected $DAO; 
    protected $model;

    public function __construct()
    {
       $this->DAO = new UsersDAO();
       $this->model = new UsersModel();
    }

    public function getUsers(Request $request, Response $response, array $args ) : Response {


        $users = $this->DAO->getAllusers();

        $response = $response->withJson($users);

        return $response;
    }
    public function insertUser(Request $request, Response $response, array $args ) : Response {

        $data = $request->getParsedBody();

        $company = "FTC265";
        $code =  rand(100000, 999999);

        $user = $this->model->setName($data['name'])
            ->setOffice($data['office'])
            ->setLogin($company)
            ->setPassword(base64_encode($code))
            ->setLevel($data['level'])
            ->setStatus($data['status']);

        $this->DAO->insertUser($user);

        $response = $response->withJson([
            'msg' => 'Usuário inserido com sucesso!',
            'data' => $user,
            'code' => $code
        ]);

        return $response;
    }
    public function updateUser(Request $request, Response $response, array $args ) : Response {

        $id = $args['id'];
        $data = $request->getParsedBody();
        

        $user = $this->model->setName($data['name'])
            ->setOffice($data['office'])
            ->setLevel($data['level'])
            ->setStatus($data['status']);

        $this->DAO->updateUser($id, $user);

        $response = $response->withJson([
            'msg' => 'Usuário atualizado com sucesso! '
        ]);

        return $response;
    }

    public function loginUser(Request $request, Response $response, array $args ) : Response {
        
        $data = $request->getParsedBody();   

        $user = $this->model->setLogin($data['login'])
            ->setPassword($data['password']);

        $login = $this->DAO->loginUser($user);

        $response = $response->withJson([
            'response' => $login
        ]);

        return $response;
    }

    public function deleteUser(Request $request, Response $response, array $args ) : Response {
        $id = $args['id'];

        $this->DAO->deleteUser($id);

        $response = $response->withJson([
            'msg' => 'Usuário deletado com sucesso! '
        ]);

        return $response;
    }
}