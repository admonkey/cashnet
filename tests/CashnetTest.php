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
    $this->assertSame(true, $setPriceResponse);
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
