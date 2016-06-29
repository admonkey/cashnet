<?php use Puckett\Cashnet\CashnetFactory;
class CashnetTest extends PHPUnit_Framework_TestCase
{
  public function testSetPrice()
  {
    // Arrange
    $cf = new CashnetFactory();

    // Act
    $setPriceResponse = $cf->setPrice();

    // Assert
    $this->assertEquals(true, $setPriceResponse);
  }
}
