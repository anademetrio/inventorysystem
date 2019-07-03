<?php

namespace App\Models;

final class UsersModel {

    private $id;
    private $name;
    private $office;
    private $login;
    private $password;
    private $level;
    private $status;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): UsersModel {
        $this->name = $name;
        return $this;
    }

    public function getOffice(): string {
        return $this->office;
    }

    public function setOffice(string $office): UsersModel {
        $this->office = $office;
        return $this;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function setLogin(string $login): UsersModel {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): UsersModel {
        $this->password = $password;
        return $this;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function setLevel(int $level): UsersModel {
        $this->level = $level;
        return $this;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setStatus(int $status): UsersModel {
        $this->status = $status;
        return $this;
    }
}