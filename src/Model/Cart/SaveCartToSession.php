<?php


namespace App\Model\Cart;

use App\Entity\Cart;

class SaveCartToSession implements SaveCartInterface
{
    protected $saver;
    public function __construct(SaveCartInterface $saver)
    {
        $this->saver = $saver;
    }

    public function save(Cart $cart): void
    {
        print 'Save cart into session<br />';
        $this->saver->save($cart);
    }
}
