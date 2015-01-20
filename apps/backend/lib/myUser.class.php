<?php

class myUser extends sfBasicSecurityUser
{
    /**
     * Retrieve data about cart saved in session var
     */
    public function getShoppingCart()
    {
        if (!$this->hasAttribute('shopping_cart'))
        {
            $this->setAttribute('shopping_cart', new sfShoppingCart(sfConfig::get('app_cart_tax')));
        }

        return $this->getAttribute('shopping_cart');
    }
}
