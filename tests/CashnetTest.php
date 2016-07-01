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
    * @dataProvider getInvalidStringData
    */
  public function testValidateStore($value)
  {
    $cf = new CashnetFactory();

    $this->assertFalse($cf->setStore($value));
    $this->assertFalse($cf->getStore());
  }

  public function getInvalidStringData()
  {
    return [
      [null],
      [0],
      [''],
      [42],
      [21.21],
      [-24],
      [-12.12],
      ['123'],
      [true],
      [false],
      [array('key' => 'value')],
      [(object) 'value']
    ];
  }

  public function testSetItemcode()
  {
    // Arrange
    $cf = new CashnetFactory();
    $value = 'ITEMCODE';

    // Act
    $setResponse = $cf->setItemcode($value);
    $getResponse = $cf->getItemcode();

    // Assert
    $this->assertSame($value, $setResponse);
    $this->assertSame($value, $getResponse);
  }

  /**
    * @depends testSetItemcode
    * @dataProvider getInvalidStringData
    */
  public function testValidateItemcode($value)
  {
    $cf = new CashnetFactory();

    $this->assertFalse($cf->setItemcode($value));
    $this->assertFalse($cf->getItemcode());
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
    * @dataProvider getInvalidPriceData
    */
  public function testValidatePrice($value)
  {
    $cf = new CashnetFactory();

    $this->assertFalse($cf->setPrice($value));
    $this->assertFalse($cf->getPrice());
  }

  public function getInvalidPriceData()
  {
    return [
      [null],
      ['not a number'],
      [0],
      [''],
      [-24],
      [-12.12],
      [true],
      [false],
      [array('key' => 'value')],
      [(object) 'value']
    ];
  }

  /**
    * @testdox Generate URL
    */
  public function testGenerateURL()
  {
    $cf = new CashnetFactory();

    $this->assertTrue($cf->getURL());
  }

}
