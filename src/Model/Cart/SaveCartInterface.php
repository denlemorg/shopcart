<?php


namespace App\Model\Cart;


use App\Entity\Cart;

interface SaveCartInterface
{
    function save(Cart $cart): void;
}