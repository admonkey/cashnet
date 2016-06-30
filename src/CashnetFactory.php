<?php namespace Puckett\Cashnet;
class CashnetFactory
{

/*
  //
  // PUBLIC METHODS
  //
  // functionName($parameters = DEFAULTS) returns
  //

  getPrice() numeric or false
  setPrice($price) boolean

  //
  // PRIVATE FUNCTIONS
  //

  requiredFieldsSet() boolean

*/

  private $price;

  //
  // PUBLIC METHODS
  //

  function __construct(
    $price = false
  )
  {
    $this->setPrice($price);
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function setPrice($price)
  {
    // validate
    if (
      !is_numeric($price) ||
      $price <= 0
    ) {
      $this->price = false;
      return false;
    } else {
      $this->price = $price;
      return true;
    }
  }

  //
  // PRIVATE FUNCTIONS
  //

  private function requiredFieldsSet()
  {
    if ($this->price === false) return false;
    return true;
  }

}
