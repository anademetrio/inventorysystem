<?php

namespace App\Models;

final class TransfersModel {

    private $id;
    private $quantity;
    private $product;
    private $store_origin;
    private $store_destiny;

    public function getId(): int {
        return $this->id;
    }

    public function getQuantity(): float {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): TransfersModel {
        $this->quantity = $quantity;
        return $this;
    }

    public function getProduct(): int {
        return $this->product;
    }

    public function setProduct(int $product): TransfersModel {
        $this->product = $product;
        return $this;
    }

    public function getStoreOrigin(): int {
        return $this->store_origin;
    }

    public function setStoreOrigin(int $store_origin): TransfersModel {
        $this->store_origin = $store_origin;
        return $this;
    }

    public function getStoreDestiny(): int {
        return $this->store_destiny;
    }

    public function setStoreDestiny(int $store_destiny): TransfersModel {
        $this->store_destiny = $store_destiny;
        return $this;
    }
}