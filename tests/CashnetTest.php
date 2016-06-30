<?php use Puckett\Cashnet\CashnetFactory;
class CashnetTest extends PHPUnit_Framework_TestCase
{

  public function testCompleteConstructor()
  {
    // Arrange
    $store = 'CASHNET-STORE';
    $itemcode = 'ITEMCODE';
    $price = 42.42;
    $data = [
      'store' => $store,
      'itemcode' => $itemcode,
      'price' => $price
    ];

    // Act
    $cf = new CashnetFactory($data);

    // Assert
    $this->assertSame(true, $cf->requiredFieldsSet());
    $this->assertSame($store, $cf->getStore());
    $this->assertSame($itemcode, $cf->getItemcode());
    $this->assertSame($price, $cf->getPrice());
  }

  /**
    * @depends testCompleteConstructor
    */
  public function testIncompleteConstructor()
  {
    // Arrange
    $store = 'CASHNET-STORE';
    $itemcode = 'ITEMCODE';
    $price = 42.42;

    // Act
    $cf_nostore = new CashnetFactory(['itemcode'=>$itemcode,'price'=>$price]);
    $cf_noitemcode = new CashnetFactory(['store'=>$store,'price'=>$price]);
    $cf_noprice = new CashnetFactory(['store'=>$store,'itemcode'=>$itemcode,]);

    // Assert
    $this->assertSame(false, $cf_nostore->requiredFieldsSet());
    $this->assertSame(false, $cf_noitemcode->requiredFieldsSet());
    $this->assertSame(false, $cf_noprice->requiredFieldsSet());
  }

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

  /**
    * @depends testSetStore
    * @dataProvider getInvalidStoreData
    */
  public function testValidateStore($value)
  {
    $cf = new CashnetFactory();

    $this->assertFalse($cf->setStore($value));
    $this->assertFalse($cf->getStore());
  }

  public function getInvalidStoreData()
  {
    return [
      [null],
      [42],
      [21.21],
      [-24],
      [-12.12],
      [true],
      [false],
      [array('key' => 'value')],
      [(object) 'value']
    ];
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

  /**
    * @depends testSetPrice
    */
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

  /**
    * @depends testSetPrice
    */
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
