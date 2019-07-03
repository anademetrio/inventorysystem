<?php

namespace App\Models;

final class StoresModel {

    private $id;
    private $name;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): StoresModel {
        $this->name = $name;
        return $this;
    }
}