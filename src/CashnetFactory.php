<?php namespace Puckett\Cashnet;
class CashnetFactory
{

/*
  --
  -- PUBLIC METHODS
  --
  -- functionName($parameters = DEFAULTS) returns
  --

  getPrice() numeric or false
  setPrice($price) boolean

*/

  private $price;

  function __construct()
  {
    $this->price = false;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function setPrice($price)
  {
    // validate
    if (!is_numeric($price)) return false;
    if ($price <= 0) return false;

    $this->price = $price;
    return true;
  }

}
