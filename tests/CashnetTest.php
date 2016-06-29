<?php use Puckett\Cashnet\CashnetFactory;
class CashnetTest extends PHPUnit_Framework_TestCase
{
  public function testSetPrice()
  {
    // Arrange
    $cf = new CashnetFactory();
    $price = 42.42;

    // Act
    $setPriceResponse = $cf->setPrice($price);
    $getPriceResponse = $cf->getPrice();

    // Assert
    $this->assertEquals(true, $setPriceResponse);
    $this->assertEquals($price, $getPriceResponse);
  }
}
