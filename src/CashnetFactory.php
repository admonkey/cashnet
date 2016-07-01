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
      'amount' => $amount
    )

  requiredFieldsSet() boolean

  getURL() URL or false

  getStore() $store or false
  setStore($store) $store or false
  getItemcode() $itemcode or false
  setItemcode($itemcode) $itemcode or false
  getAmount() numeric or false
  setAmount($amount) numeric or false

  getData() $data or false
  setData($data) $data or false
    // setData will overwrite all values
*/

  private $data;

  //
  // PUBLIC METHODS
  //

  function __construct($data = null)
  {
    $this->setData($data);
  }

  public function requiredFieldsSet()
  {
    if ($this->getStore() === false) return false;
    if ($this->getItemcode() === false) return false;
    if ($this->getAmount() === false) return false;
    return true;
  }

  public function getURL()
  {
    if(!$this->requiredFieldsSet()) return false;

    $url  = 'https://commerce.cashnet.com/';
    $url .= rawurlencode($this->getStore()) . '?';

    $data = $this->data;
    unset($data['store']);

    return $url . http_build_query($data);
  }

  public function getStore()
  {
    return $this->data['store'];
  }

  public function setStore($store)
  {
    if (
      !is_string($store) ||
      empty($store) ||
      is_numeric($store)
    )    $this->data['store'] = false;
    else $this->data['store'] = $store;

    return $this->data['store'];
  }

  public function getItemcode()
  {
    return $this->data['itemcode'];
  }

  public function setItemcode($itemcode)
  {
    if (
      !is_string($itemcode) ||
      empty($itemcode) ||
      is_numeric($itemcode)
    )    $this->data['itemcode'] = false;
    else $this->data['itemcode'] = $itemcode;

    return $this->data['itemcode'];
  }

  public function getAmount()
  {
    return $this->data['amount'];
  }

  public function setAmount($amount)
  {
    // validate
    if (
      !is_numeric($amount) ||
      $amount <= 0
    ) {
      $this->data['amount'] = false;
    } else {
      $this->data['amount'] = $amount;
    }

    return $this->data['amount'];
  }

  public function getData()
  {
    return $this->data;
  }

  public function setData($data)
  {
    $data['store'] = $this->setStore(@$data['store']);
    $data['itemcode'] = $this->setItemcode(@$data['itemcode']);
    $data['amount'] = $this->setAmount(@$data['amount']);

    return $this->data = $data;
  }

}
