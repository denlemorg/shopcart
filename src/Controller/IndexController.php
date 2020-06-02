<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Cart;
use App\Model\Cart\CartManager;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/index", name="index")
     *
     * @param CartManager $cartManager
     * @param ProductRepository $productRepository
     * @param CartRepository $cartRepository
     * @return void
     */
    public function index(CartManager $cartManager, ProductRepository $productRepository, CartRepository $cartRepository)
    {

        $products = $productRepository->findAll();

        $cart = $cartManager->addProduct($products[0]);

        $cartRepository->savePolymorphCart($cart);

        dd($cart);

    }
}
