<?php

namespace App\Models;

final class InventoriesModel {

    private $id;
    private $quantity;
    private $type;
    private $detail;
    private $product;
    private $store;
    private $transfer;

    public function getId(): int {
        return $this->id;
    }

    public function getQuantity(): float {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): InventoriesModel {
        $this->quantity = $quantity;
        return $this;
    }
    
    public function getType(): int {
        return $this->type;
    }

    public function setType(int $type): InventoriesModel {
        $this->type = $type;
        return $this;
    }
    
    public function getDetail(): string {
        return $this->detail;
    }

    public function setDetail(string $detail): InventoriesModel {
        $this->detail = $detail;
        return $this;
    }
    
    public function getProduct(): int {
        return $this->product;
    }

    public function setProduct(int $product): InventoriesModel {
        $this->product = $product;
        return $this;
    }
    
    public function getStore(): int {
        return $this->store;
    }

    public function setStore(int $store): InventoriesModel {
        $this->store = $store;
        return $this;
    }

    public function getTransfer(): string {
        return $this->transfer;
    }

    public function setTransfer(string $transfer): InventoriesModel {
        $this->transfer = $transfer;
        return $this;
    }
}