<?php

namespace App\Models;

final class ProductsModel {

    private $id;
    private $name;
    private $stock;
    private $image;
    private $value;
    private $unity;
    private $status;
    private $category;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): ProductsModel {
        $this->name = $name;
        return $this;
    }


    public function getStock(): float {
        return $this->stock;
    }

    public function setStock(float $stock): ProductsModel {
        $this->stock = $stock;
        return $this;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(string $image): ProductsModel {
        $this->image = $image;
        return $this;
    }

    public function getValue(): float {
        return $this->value;
    }

    public function setValue(float $value): ProductsModel {
        $this->value = $value;
        return $this;
    }

    public function getUnity(): string {
        return $this->unity;
    }

    public function setUnity(string $unity): ProductsModel {
        $this->unity = $unity;
        return $this;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setStatus(int $status): ProductsModel {
        $this->status = $status;
        return $this;
    }

    public function getCategory(): int {
        return $this->category;
    }

    public function setCategory(int $category): ProductsModel {
        $this->category = $category;
        return $this;
    }
}