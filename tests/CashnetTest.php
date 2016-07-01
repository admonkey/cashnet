<?php use Puckett\Cashnet\CashnetFactory;
class CashnetTest extends PHPUnit_Framework_TestCase
{

  public function testCompleteConstructor()
  {
    // Arrange
    $store = 'CASHNET-STORE';
    $itemcode = 'ITEMCODE';
    $amount = 42.42;
    $data = [
      'store' => $store,
      'itemcode' => $itemcode,
      'amount' => $amount
    ];

    // Act
    $cf = new CashnetFactory($data);

    // Assert
    $this->assertSame(true, $cf->requiredFieldsSet());
    $this->assertSame($store, $cf->getStore());
    $this->assertSame($itemcode, $cf->getItemcode());
    $this->assertSame($amount, $cf->getAmount());
  }

  /**
    * @depends testCompleteConstructor
    */
  public function testIncompleteConstructor()
  {
    // Arrange
    $store = 'CASHNET-STORE';
    $itemcode = 'ITEMCODE';
    $amount = 42.42;

    // Act
    $cf_nostore = new CashnetFactory(['itemcode'=>$itemcode,'amount'=>$amount]);
    $cf_noitemcode = new CashnetFactory(['store'=>$store,'amount'=>$amount]);
    $cf_noamount = new CashnetFactory(['store'=>$store,'itemcode'=>$itemcode,]);

    // Assert
    $this->assertSame(false, $cf_nostore->requiredFieldsSet());
    $this->assertSame(false, $cf_noitemcode->requiredFieldsSet());
    $this->assertSame(false, $cf_noamount->requiredFieldsSet());
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

  public function testSetAmount()
  {
    // Arrange
    $cf = new CashnetFactory();
    $amount = 42.42;

    // Act
    $setAmountResponse = $cf->setAmount($amount);
    $getAmountResponse = $cf->getAmount();

    // Assert
    $this->assertSame($amount, $setAmountResponse);
    $this->assertSame($amount, $getAmountResponse);
  }

  /**
    * @depends testSetAmount
    * @dataProvider getInvalidAmountData
    */
  public function testValidateAmount($value)
  {
    $cf = new CashnetFactory();

    $this->assertFalse($cf->setAmount($value));
    $this->assertFalse($cf->getAmount());
  }

  public function getInvalidAmountData()
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
    * @dataProvider getUrlData
    */
  public function testSetData($data, $url)
  {
    // Arrange
    $cf = new CashnetFactory();

    // Act
    $setResponse = $cf->setData($data);
    $getResponse = $cf->getData();

    // Assert
    $this->assertSame($data, $setResponse);
    $this->assertSame($data, $getResponse);
  }

  /**
    * @depends testCompleteConstructor
    * @testdox Generate URL
    * @dataProvider getUrlData
    */
  public function testGenerateURL($data, $url)
  {
    $cf = new CashnetFactory($data);

    $this->assertSame($url, $cf->getURL());
  }

  public function getUrlData()
  {
    return [
      'Minimum Data' => [
        'data' => [
          'store' => 'CASHNET-STORE',
          'itemcode' => 'ITEMCODE',
          'amount' => 42.21
        ],
        'url' => 'https://commerce.cashnet.com/CASHNET-STORE?itemcode=ITEMCODE&amount=42.21'
      ],
      'Cashnet Globals' => [
        'data' => [
          'store' => 'CASHNET-STORE',
          'itemcode' => 'ITEMCODE',
          'amount' => 42.21,
          'CARDNAME_G' => 'John G.'
        ],
        'url' => 'https://commerce.cashnet.com/CASHNET-STORE?itemcode=ITEMCODE&amount=42.21&CARDNAME_G=John+G.'
      ]
    ];
  }

}
