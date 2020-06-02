<?php

namespace App\Model\Cart;

use App\Model\Cart\Product\CartProduct;
use App\Model\Cart\Provider\ProductProviderInterface;

class Cart
{
    private $productProvider;
    private $user;

    public function __construct(int $user, ProductProviderInterface $productProvider)
    {
        $this->productProvider = $productProvider;
        $this->user            = $user;
    }

    public function addProduct(CartProduct $productToAdd): self
    {
        $products = $this->productProvider->getAll($this->user);

        foreach ($products as $product) {
            if ($product->getId() === $productToAdd->getId()) {
                $product->appendCount();
                break;
            }
        }

        $products[] = $productToAdd;

        $this->productProvider->save($this->user, ...$products);

        return $this;
    }

    public function removeProduct(CartProduct $productToRemove): self
    {
        $products = $this->productProvider->getAll($this->user);
        foreach ($products as $i => $product) {
            if ($product->getId() === $productToRemove->getId()) {
                $product->decrementCount();
            }
        }

        $this->productProvider->save($this->user, ...$products);

        return $this;
    }

    public function totalPrice(): int
    {
        $products = $this->productProvider->getAll($this->user);

        $total = array_reduce(
            $products,
            static function (int $total, CartProduct $product): int {
                if ($product->getCount() < 0 || $product->getPrice()->getCoins() < 0) {
                    throw new \LogicException('Err');
                }

                $total += $product->getPrice()->getCoins() * $product->getCount();

                return $total;
            },
            0
        );

        return $total < 0 ? 0 : $total;
    }
}
