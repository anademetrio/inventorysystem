<?php

namespace App\Models;

final class CategoriesModel {

    private $id;
    private $name;
    private $status;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): CategoriesModel {
        $this->name = $name;
        return $this;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setStatus(int $status): CategoriesModel {
        $this->status = $status;
        return $this;
    }
}