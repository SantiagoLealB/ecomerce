<?php
namespace App;
//configurar para enviar a paypal lo que se cobrará

class PayPal{

	private $_apiContext;//lo que se envia apaypal
	private $shopping_cart;//carrito que se cobrará
	private $_ClientId = 'Af0t28PKjqOyk4MY8LWwpQ5v6n9eck6u36Qz3xDagC9OBSOjLgdSVCFVf596BrZIUQ9xM0ayVKxACRc0';
 	private $_ClientSecret = 'ELRhXQEqCwVsusiPBJm_WNzxPoTbJsvCXl0D2lfVaYbZFlMQNGG-xeXoW5xPM9Gs5fMo71Kr4ghJ9SxL';

	public function __construct($shopping_cart){

		$this->_apiContext = \PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret);
		$config = config('paypal_payment'); //archivo de configuración
		//tranformar configuración en arreglo plano
		$flatConfig = array_dot($config);

		$this->_apiContext->setConfig($flatConfig); 
		$this->shopping_cart  = $shopping_cart;

	}

	//generar el pago
	public function generate(){
		//setpayer= tipo de pago(paypal,tatjeta)
		//setTransaction = cosas que se van a cobrar
		//se envia a paypal y regresa un mensaje si pago o cancelo depues se envia a setRedirectUrls
		$payment = \PaypalPayment::payment()->setIntent('sale')
			->setPayer($this->payerType())
			->setTransactions([$this->transacccion() ])
			->setRedirectUrls($this->redirectURLs());

		//enviar el pago a paypal
		try {
			$payment->create($this->_apiContext);
		} catch (\Exception $e) {
			dd($e);
			exit(1);		
		}	
		//si se ejecuta el try
		return $payment;
	}

	//obtener info del pagador y tipo de pago(paypal o tarjeta)
	public function payerType(){
		return \PaypalPayment::payer()->setPaymentMethod('paypal'); //puede ser con tarjeta

	}

	//retorna la  url a donde se dirigira despues del pago o la cancelación del pago
	public function redirectURLs(){

		$baseURL = url('/');//obtener la url del proyecto
		return \PaypalPayment::redirectUrls()
				->setReturnUrl($baseURL . '/payments/store')
				->setCancelUrl($baseURL . '/carrito') ;

	}

	//retorna la informacion de la transaction, costo
	public function transacccion(){

		return \PaypalPayment::transaction()
				->setAmount($this->amount())
				->setItemList($this->items())
				->setDescription('Tu compra en Ecomerce')
				->setInvoiceNumber(uniqid());//como un cobro

	}

	//tipo de moneda y total, solo acepta dolar, se puede hacer una conversion a pesos
	public function  amount(){

		return \PaypalPayment::amount()->setCurrency('USD')->setTotal($this->shopping_cart->total());
	}

	//que es lo que se esta cobrando(productos,cantidad,precios)
	public function items(){

		$items = [];

		$products = $this->shopping_cart->products()->get();
		
		foreach ($products as $product) {
			//llenar el arreglo, paypalItem() = metodo del modelo product
			array_push($items, $product->paypalItem());
		}

		return \PaypalPayment::itemList()->setItems($items);
	}

	//ejecutar el cobro, retirar ypasar el saldo al vendedor
	public function execute($paymentId, $payerId){
		//pasar losparametros recibidos de paypal
		$payment = \PaypalPayment::getById($paymentId, $this->_apiContext);
		//ejucatar el cobro
		$execution = \PaypalPayment::PaymentExecution()
									->setPayerId($payerId);
		//retornar lo que responda
		return $payment->execute($execution, $this->_apiContext);//metodo de la api de paypal

	}
}