<?php namespace Puckett\Cashnet;
class CashnetFactory
{

/*
  //
  // PUBLIC METHODS
  //
  // functionName($parameters = DEFAULTS) returns
  //

  __construct($store = FALSE, $itemcode = FALSE, $price = FALSE)
  requiredFieldsSet() boolean
  getStore() $store or false
  setStore($store) $store or false
  getItemcode() $itemcode or false
  setItemcode($itemcode) $itemcode or false
  getPrice() numeric or false
  setPrice($price) numeric or false

*/

  private $store;
  private $itemcode;
  private $price;

  //
  // PUBLIC METHODS
  //

  function __construct(
    $store = false,
    $itemcode = false,
    $price = false
  )
  {
    $this->store = $store;
    $this->itemcode = $itemcode;
    $this->setPrice($price);
  }

  public function requiredFieldsSet()
  {
    if ($this->store === false) return false;
    if ($this->itemcode === false) return false;
    if ($this->price === false) return false;
    return true;
  }


  public function getStore()
  {
    return $this->store;
  }

  public function setStore($store)
  {
    $this->store = $store;
    return $this->store;
  }

  public function getItemcode()
  {
    return $this->itemcode;
  }

  public function setItemcode($itemcode)
  {
    $this->itemcode = $itemcode;
    return $this->itemcode;
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
    } else {
      $this->price = $price;
    }

    return $this->price;
  }

}
