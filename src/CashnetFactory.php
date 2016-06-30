<?php namespace Puckett\Cashnet;
class CashnetFactory
{

/*
  //
  // PUBLIC METHODS
  //
  // functionName($parameters = DEFAULTS) returns
  //

  __construct($data = NULL)
    $data = array(
      'store' => $store,
      'itemcode' => $itemcode,
      'price' => $price
    )
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

  function __construct($data = null)
  {
    if(isset($data['store']))
      $this->setStore($data['store']);
    else $this->store = false;

    if(isset($data['itemcode']))
      $this->setItemcode($data['itemcode']);
    else $this->itemcode = false;

    if(isset($data['price']))
      $this->setPrice($data['price']);
    else $this->price = false;
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
    if (
      !is_string($store) ||
      empty($store) ||
      is_numeric($store)
    )    $this->store = false;
    else $this->store = $store;

    return $this->store;
  }

  public function getItemcode()
  {
    return $this->itemcode;
  }

  public function setItemcode($itemcode)
  {
    if (
      !is_string($itemcode) ||
      empty($itemcode) ||
      is_numeric($itemcode)
    )    $this->itemcode = false;
    else $this->itemcode = $itemcode;

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
