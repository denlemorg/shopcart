<?php


namespace App\Model\Cart;


use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;


class CartManager
{
    private $cart;
    private $cartRepository;

    /**
     * Constructor
     *
     * CartManager constructor.
     * @param CartRepository $cartRepository
     */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->cart = $this->cartRepository->findOneBy(['customer' => '1']);
    }

    /**
     * @param Product $product
     * @return Cart
     */
    public function addProduct(Product $product): Cart
    {
        $cartProducts = $this->cart->getProducts();
        $cartProducts[] = $product->getId();
        $this->cart->setProducts($cartProducts);
        return $this->cart;
    }

}