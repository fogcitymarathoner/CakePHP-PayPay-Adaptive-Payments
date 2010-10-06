<?php 
/**
 * Paypal Direct Payment API Component class file.
 */
App::import('Vendor','paypal' ,array('file'=>'paypal/PaypalAdaptive.php'));
class PaypalAdaptiveComponent extends Object{
	
	var $myinstallpath;

	function processPayment($paymentInfo, $function){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);

		if ($function=="DoDirectPayment")
			return $paypal->DoDirectPayment($paymentInfo);
		elseif ($function=="SetExpressCheckout")
			return $paypal->SetExpressCheckout($paymentInfo);
		elseif ($function=="GetExpressCheckoutDetails")
			return $paypal->GetExpressCheckoutDetails($paymentInfo);
		elseif ($function=="DoExpressCheckoutPayment")
			return $paypal->DoExpressCheckoutPayment($paymentInfo);
		elseif ($function=="AdaptivePayment2Receivers")
			return $paypal->AdaptivePayment2Receivers($paymentInfo);
		elseif ($function=="SyncWithPP")
			return $paypal->SyncWithPP($paymentInfo);
		elseif ($function=="AdaptivePaymentDetails")
			return $paypal->AdaptivePaymentDetails($paymentInfo);
			else
			return "Function Does Not Exist!";
	}	
	function getReturnURL(){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);
		return $paypal->ReturnURL();
	}
	function getCancelURL(){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);
		return $paypal->CancelURL();
	}
	function getPaypalURL(){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);
		return $paypal->PaypalURL();
	}
	function getPaypalApprovePaymentURL(){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);
		return $paypal->PaypalApprovePaymentURL();
	}
	function receiver1TransactionInfoFromDetails($response,$id){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);
		return $paypal->receiver1TransactionInfoFromDetails($response,$id);
	}
	function receiver2TransactionInfoFromDetails($response,$id){
		$this->myinstallpath = Configure::read('myinstallpath');
		$paypal = new Paypal($this->myinstallpath);
		return $paypal->receiver2TransactionInfoFromDetails($response,$id);
	}
}
?>