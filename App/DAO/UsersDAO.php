<?php

namespace App\DAO;

use src\appFunctions;
use App\Models\UsersModel;


class UsersDAO extends Connection
{

    protected $fn;

    public function __construct()
    {
        parent::__construct();

        $this->fn = new appFunctions();
    }
    public function getAllusers(): array
    {
        $users = $this->pdo
            ->query('SELECT * FROM `users`')
            ->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($users as $row) {
            $data[] = [
                "id"                => $row['id'],
                "name"              => $row['name'],
                "office"            => $row['office'],
                "date"              => $this->fn->setDateToBR($row['date']),
                "level"             => $row['level'],
                "status"            => $row['status'],

            ];
        }

        return $data;
    }

    public function insertUser(UsersModel $users): void
    {

        $statemant = $this->pdo
            ->prepare('INSERT INTO users (`name`,`office`,`login`,`password`,`date`,`level`,`status`) 
                VALUES(:name, :office, :login, :password, NOW(), :level, :status)');
        $statemant->execute([
            'name' => $users->getName(),
            'office' => $users->getOffice(),
            'login' => $users->getLogin(),
            'password' => $users->getPassword(),
            'level' => $users->getLevel(),
            'status' => $users->getStatus(),
        ]);
    }

    public function updateUser($id, UsersModel $users): void
    {

        $statemant = $this->pdo
            ->prepare('UPDATE users SET  `name` = :name , `office` = :office , `level` = :level, `status` = :status WHERE id = :id');
        $statemant->execute([
            'id' => $id,
            'name' => $users->getName(),
            'office' => $users->getOffice(),
            'level' => $users->getLevel(),
            'status' => $users->getStatus(),
        ]);
    }

    public function loginUser(UsersModel $users)
    {

        $login = $users->getLogin();
        $pass = base64_encode($users->getPassword());

        $statemant = $this->pdo
            ->query("SELECT * FROM `users`
        WHERE login = '$login' AND password = '$pass'")
            ->fetchAll(\PDO::FETCH_ASSOC);
            
        $data = [];
        if(count($statemant) > 0) {
            foreach ($statemant as $row) {
                $data[] = [
                    "id"                => $row['id'],
                    "name"              => $row['name'],
                    "office"            => $row['office'],
                    "date"              => $this->fn->setDateToBR($row['date']),
                    "level"             => $row['level'],
                    "status"            => $row['status'],
                    "success"           => true
    
                ];
            }
        } else {
            $data[] = [
                "success"           => false,
                "msg"               => "Dados incorretos!"
            ];
        }
        

        return $data;
    }

    public function deleteUser($id): void
    {

        $statemant = $this->pdo
            ->prepare('DELETE FROM `users` WHERE id = :id');
        $statemant->execute([
            'id' => $id,
        ]);
    }
}
