<?php namespace Puckett\Cashnet;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Twig_Environment;
use Twig_Loader_Filesystem;

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

  // validate your data
  requiredFieldsSet() boolean

  // get the cashnet page
  getURL($options = null) URL or false
    ['HTML' => true] returns HTML fragment

  // manipulate cashnet settings
  getStore() $store or false
  setStore($store) $store or false
  getItemcode() $itemcode or false
  setItemcode($itemcode) $itemcode or false

  // callback page
  getSignouturl() URL or false
  setSignouturl($url) URL or false

  // price
  getAmount() numeric or false
  setAmount($amount) numeric or false

  // overwrite all values
  getData() $data or false
  setData($data) $data or false

  // complete fields
  getForm($allowOverride = false) string (HTML <form>)

  createDatabaseTransaction() boolean
*/

  private $data;
  private $twig;
  private $formFactory;
  private $request;
  private $pdoDB;

  //
  // PUBLIC METHODS
  //

  function __construct($data = null, $pdo = null)
  {
    $this->pdoDB = $pdo;

    $this->setData($data);
    // the Twig file that holds all the default markup for rendering forms
    // this file comes with TwigBridge
    $defaultFormTheme = 'form_div_layout.html.twig';

    $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
    $vendorTwigBridgeDir = dirname($appVariableReflection->getFileName());
    // the path to your other templates
    $viewsDir = realpath(__DIR__.'/../views');

    $this->twig = new Twig_Environment(new Twig_Loader_Filesystem(array(
        $viewsDir,
        $vendorTwigBridgeDir.'/Resources/views/Form',
    )));
    $formEngine = new TwigRendererEngine(array($defaultFormTheme));

    $this->twig->addExtension(
        new FormExtension(new TwigRenderer($formEngine))
    );

    $this->twig->addExtension(
        new TranslationExtension(new Translator('en'))
    );

    $formEngine->setEnvironment($this->twig);

    // Set up the Validator component
    $validator = Validation::createValidator();

    // create your form factory as normal
    $this->formFactory = Forms::createFormFactoryBuilder()
        ->addExtension(new HttpFoundationExtension())
        ->addExtension(new ValidatorExtension($validator))
        ->getFormFactory();

    $this->request = Request::createFromGlobals();
  }

  public function requiredFieldsSet()
  {
    if ($this->getStore() === false) return false;
    if ($this->getItemcode() === false) return false;
    if ($this->getAmount() === false) return false;
    if ($this->getSignouturl() === false) return false;
    return true;
  }

  public function getURL($options = null)
  {
    if(!$this->requiredFieldsSet()) return false;

    $url  = 'https://commerce.cashnet.com/';
    $url .= rawurlencode($this->getStore()) . '?';

    $data = $this->getData();
    unset($data['store']);
    $data['signouturl'] = urldecode($data['signouturl']);

    $url .= http_build_query($data);

    if (!empty($options['HTML'])) {
      return $this->twig->render('url.html.twig', array(
        'url' => $url,
        'data' => $this->getData()
      ));
    } else return $url;
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

  public function getSignouturl()
  {
    return $this->data['signouturl'];
  }

  public function setSignouturl($url)
  {
    // TODO: validate URL

    if(isset($url))
      $this->data['signouturl'] = $url;
    else
      $this->data['signouturl'] = false;

    return $this->data['signouturl'];
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
    $data['signouturl'] = $this->setSignouturl(@$data['signouturl']);

    return $this->data = $data;
  }

  public function getForm($allowOverride = false)
  {
    $data = $this->getData();

    if ($allowOverride !== true)
      $data = array_filter($data, function($var){return empty($var);});

    $defaults = $data;

    if(empty($data['amount']))
      unset($defaults['amount']);

    $formBuilder = $this->formFactory->createBuilder(FormType::class,$defaults);

    if (isset($data['amount'])){
      $formBuilder->add("amount", MoneyType::class, ['currency' => 'USD']);
      unset($data['amount']);
    }

    if (isset($data['signouturl'])){
      $formBuilder->add("signouturl", UrlType::class);
      unset($data['signouturl']);
    }

    foreach ($data as $key => $value){
      $formBuilder->add("$key", TextType::class);
    }

    $form = $formBuilder->getForm();

    $form->handleRequest($this->request);

    if ($form->isValid()) {

        $this->setData(array_merge($this->getData(), $form->getData()));

        if($this->requiredFieldsSet()){

          $this->createDatabaseTransaction();

          return $this->getURL(['HTML'=>true]);
        }
    }

    return $this->twig->render('form.html.twig', array(
        'form' => $form->createView(),
    ));
  }

  public function createDatabaseTransaction(){
    if (is_null($this->pdoDB)) return false;

    return false;
  }

}
