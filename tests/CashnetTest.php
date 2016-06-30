<?php use Puckett\Cashnet\CashnetFactory;
class CashnetTest extends PHPUnit_Framework_TestCase
{

  public function testSetStore()
  {
    // Arrange
    $cf = new CashnetFactory();
    $store = 'CASHNET-STORE';

    // Act
    $setStoreResponse = $cf->setStore($store);
    $getStoreResponse = $cf->getStore();

    // Assert
    $this->assertSame($store, $setStoreResponse);
    $this->assertSame($store, $getStoreResponse);
  }

  public function testSetPrice()
  {
    // Arrange
    $cf = new CashnetFactory();
    $price = 42.42;

    // Act
    $setPriceResponse = $cf->setPrice($price);
    $getPriceResponse = $cf->getPrice();

    // Assert
    $this->assertSame($price, $setPriceResponse);
    $this->assertSame($price, $getPriceResponse);
  }

  public function testValidateNumericPrice()
  {
    // Arrange
    $cf = new CashnetFactory();
    $price = 'not a number';

    // Act
    $setPriceResponse = $cf->setPrice($price);
    $getPriceResponse = $cf->getPrice();

    // Assert
    $this->assertSame(false, $setPriceResponse);
    $this->assertSame(false, $getPriceResponse);
  }

  public function testValidatePositivePrice()
  {
    // Arrange
    $cf = new CashnetFactory();
    $price = -21.34;

    // Act
    $setPriceResponse = $cf->setPrice($price);
    $getPriceResponse = $cf->getPrice();

    // Assert
    $this->assertSame(false, $setPriceResponse);
    $this->assertSame(false, $getPriceResponse);
  }

}
