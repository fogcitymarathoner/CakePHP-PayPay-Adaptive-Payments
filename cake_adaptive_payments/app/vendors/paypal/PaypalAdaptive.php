<?php
/***********************************************************
This File Sets Up Calls to Paypal by arranging url information.
***********************************************************/
class Paypal {

	// Start Marc Condon
	//var $wwwInstallBase = 'http://localhost/paypaladaptive';
	var $wwwInstallBase = '';

	/*
	var $ppBase = 'https://svcs.sandbox.paypal.com/AdaptivePayments/' ; 
	var $ppApprovePaymentURL = 'https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&';
	
	var $bodyCommon = array ('requestEnvelope.errorLanguage' => 'en_US',
					'requestEnvelope.detailLevel' => 'ReturnAll',
					'clientDetails.applicationId' => 'APP-80W284485P519543T',
					'clientDetails.deviceId' => '127.0.0.1',
					'clientDetails.ipAddress' => '127.0.0.1',
					'clientDetails.partnerName' => 'Ekotable',
					'currencyCode' => 'USD',);
	var $headersCommon = Array
				(
					'X-PAYPAL-REQUEST-DATA-FORMAT' => 'NV',
					'X-PAYPAL-RESPONSE-DATA-FORMAT' => 'NV',
					'X-PAYPAL-SECURITY-USERID' => 'ekotab_1266789563_biz_api1.fogtest.com',
					'X-PAYPAL-SECURITY-PASSWORD' => '1266789572',
					'X-PAYPAL-SECURITY-SIGNATURE' => 'Ajmvmx.GWpSAvw5sDJ17JSB8N0h8AkwnZ9BFnhxiqwAENw8ECL-UPTm-',
					'X-PAYPAL-SERVICE-VERSION' => '1.1.0',
					'X-PAYPAL-APPLICATION-ID' => 'APP-80W284485P519543T',
					'CLIENT_AUTH' => ''
				);
	*/

	var $adaptivePaymentConstants = array();
	var $adaptivePaymentDetailsConstants = array();

	function __construct($installPath) {
		$this->wwwInstallBase = $installPath;

		/*
		 * This reads the ini file and makes the sections available as class members
		 * For example, $this->bodyCommon, $this->headersCommon
		 */
		$settings_array = parse_ini_file('paypal_settings.ini', true);
		foreach($settings_array as $setting_key => $setting_values) {
			$this->{$setting_key} = $setting_values;
		}
		//debug($settings_array);

		// This array sets up for payments
		$this->adaptivePaymentConstants = 
		Array
		(
			'PAYPAL_URL_ADAPTIVE'=>$this->ppBase.'Pay',
			'BODY' => Array
				(
					'actionType' => 'PAY',
					'cancelUrl' => $this->wwwInstallBase.'/adaptive_checkouts/cancel/',
					'returnUrl' => $this->wwwInstallBase.'/adaptive_checkouts/testpayment1/3/',
					'feesPayer' => 'EACHRECEIVER',
				),
		
		);
		// This array sets up for getting payment details on transactions established with PP
		$this->adaptivePaymentDetailsConstants = 
		Array
		(
			'PAYPAL_URL_ADAPTIVE'=>$this->ppBase.'PaymentDetails',
			'HEADERS' => array( 'CLIENT_AUTH'=>'Nocert',),
			'BODY' => Array
					(
						'cancelUrl' => $this->wwwInstallBase.'/adaptive_checkouts/cancel/',
						'returnUrl' => $this->wwwInstallBase.'adaptive_checkouts/testpayment1/3/',
					),
		);
	}
	// End Marc Condon

	function DoDirectPayment($paymentInfo=array()) {
		/*
		 * Get required parameters from the web form for the request
		 */
		$paymentType =urlencode('Sale');
		$firstName =urlencode($paymentInfo['Member']['first_name']);
		$lastName =urlencode($paymentInfo['Member']['last_name']);
		$creditCardType =urlencode($paymentInfo['CreditCard']['credit_type']);
		$creditCardNumber = urlencode($paymentInfo['CreditCard']['card_number']);
		$expDateMonth =urlencode($paymentInfo['CreditCard']['expiration_month']);
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		$expDateYear =urlencode($paymentInfo['CreditCard']['expiration_year']);
		$cvv2Number = urlencode($paymentInfo['CreditCard']['cv_code']);
		$address1 = urlencode($paymentInfo['Member']['billing_address']);
		$address2 = urlencode($paymentInfo['Member']['billing_address2']);
		$country = urlencode($paymentInfo['Member']['billing_country']);
		$city = urlencode($paymentInfo['Member']['billing_city']);
		$state =urlencode($paymentInfo['Member']['billing_state']);
		$zip = urlencode($paymentInfo['Member']['billing_zip']);

		$amount = urlencode($paymentInfo['Order']['theTotal']);
		$currencyCode="USD";
		$paymentType=urlencode('Sale');
		$ip=$_SERVER['REMOTE_ADDR'];

		/*
		 * Construct the request string that will be sent to PayPal.
		 * The variable $nvpstr contains all the variables and is a
		 * name value pair string with & as a delimiter
		 */
		$nvpstr="&PAYMENTACTION=Sale&IPADDRESS=$ip&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&STREET2=$address2&CITY=$city&STATE=$state".
		"&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyCode";

		/*
		 * Make the API call to PayPal, using API signature.
		 * The API response is stored in an associative array called $resArray
		 */
		$resArray=$this->hash_call("doDirectPayment",$nvpstr);
		
		/*
		 * Display the API response back to the browser.
		 * If the response from PayPal was a success, display the response parameters'
		 * If the response was an error, display the errors received using APIError.php.
		 */
		return $resArray;
		//Contains 'TRANSACTIONID,AMT,AVSCODE,CVV2MATCH, Or Error Codes'
	}

	function SetExpressCheckout($paymentInfo=array()) {
		$amount = urlencode($paymentInfo['Order']['theTotal']);
		$paymentType=urlencode('Sale');
		$currencyCode=urlencode('USD');
		$returnURL =urlencode($paymentInfo['Order']['returnUrl']);
		$cancelURL =urlencode($paymentInfo['Order']['cancelUrl']);

		$nvpstr='&AMT='.$amount.'&PAYMENTACTION='.$paymentType.'&CURRENCYCODE='.$currencyCode.'&RETURNURL='.$returnURL.'&CANCELURL='.$cancelURL;
		$resArray=$this->hash_call("SetExpressCheckout",$nvpstr);
		return $resArray;
	}

	function GetExpressCheckoutDetails($token) {
		$nvpstr='&TOKEN='.$token;
		$resArray=$this->hash_call("GetExpressCheckoutDetails",$nvpstr);
		return $resArray;
	}

	function DoExpressCheckoutPayment($paymentInfo=array()) {
		$paymentType='Sale';
		$currencyCode='USD';
		$serverName = $_SERVER['SERVER_NAME'];
		$nvpstr='&TOKEN='.urlencode($paymentInfo['TOKEN']).'&PAYERID='.urlencode($paymentInfo['PAYERID']).'&PAYMENTACTION='.urlencode($paymentType).'&AMT='.urlencode($paymentInfo['ORDERTOTAL']).'&CURRENCYCODE='.urlencode($currencyCode).'&IPADDRESS='.urlencode($serverName); 
		$resArray=$this->hash_call("DoExpressCheckoutPayment",$nvpstr);
		return $resArray;
	}

	function ReturnURL() {
		return $this->adaptivePaymentConstants['BODY']['returnUrl'];
	}

	function CancelURL() {
		return $this->adaptivePaymentConstants['BODY']['cancelUrl'];
	}

	function PaypalURL() {
		return $this->adaptivePaymentConstants['PAYPAL_URL_ADAPTIVE'];
	}

	function PaypalApprovePaymentURL() {
		return $this->ppApprovePaymentURL;
	}

	function receiver1TransactionInfoFromSync($response,$id) {
		//parse the ap key from the response
		$key = explode("&",$response); //debug($key);exit;
		//Save Receiver 1's transaction info
		$ret['AdaptivePaymentsTransaction']['payKey'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		$ret['AdaptivePaymentsTransaction']['adaptive_payment_id'] = $id;
		$ret['AdaptivePaymentsTransaction']['id'] = substr($key[7], strrpos($key[7], '=')+1, strlen($key[7]));
		$ret['AdaptivePaymentsTransaction']['transactionStatus'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		$ret['AdaptivePaymentsTransaction']['amount'] = substr($key[7], strrpos($key[7], '=')+1, strlen($key[7]));
		$ret['AdaptivePaymentsTransaction']['email'] = urldecode(substr($key[8], strrpos($key[8], '=')+1, strlen($key[8])));
		$ret['AdaptivePaymentsTransaction']['primary'] = substr($key[9], strrpos($key[9], '=')+1, strlen($key[9]));
		$ret['AdaptivePaymentsTransaction']['refundAmount'] = substr($key[12], strrpos($key[12], '=')+1, strlen($key[12]));
		$ret['AdaptivePaymentsTransaction']['refundPending'] = substr($key[13], strrpos($key[13], '=')+1, strlen($key[13]));
		$ret['AdaptivePaymentsTransaction']['senderTransactionsStatus'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		return $ret;
	}

	function receiver2TransactionInfoFromSync($response,$id) {
		//parse the ap key from the response
		$key = explode("&",$response); //debug($key);exit;
		//Save Receiver 2's transaction info
		$ret['AdaptivePaymentsTransaction']['payKey'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		$ret['AdaptivePaymentsTransaction']['adaptive_payment_id'] = $id;
		$ret['AdaptivePaymentsTransaction']['id'] = substr($key[23], strrpos($key[23], '=')+1, strlen($key[23]));
		$ret['AdaptivePaymentsTransaction']['transactionStatus'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		$ret['AdaptivePaymentsTransaction']['amount'] = substr($key[10], strrpos($key[10], '=')+1, strlen($key[10]));
		$ret['AdaptivePaymentsTransaction']['email'] = urldecode(substr($key[11], strrpos($key[11], '=')+1, strlen($key[11])));
		$ret['AdaptivePaymentsTransaction']['primary'] = substr($key[12], strrpos($key[12], '=')+1, strlen($key[12]));
		$ret['AdaptivePaymentsTransaction']['refundAmount'] = substr($key[21], strrpos($key[21], '=')+1, strlen($key[21]));
		$ret['AdaptivePaymentsTransaction']['refundPending'] = substr($key[22], strrpos($key[22], '=')+1, strlen($key[22]));
		$ret['AdaptivePaymentsTransaction']['senderTransactionsStatus'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		return $ret;
	}

	function receiver1TransactionInfoFromDetails($response,$id) {
		//parse the ap key from the response
		$key = explode("&",$response); //debug($key);exit;
		//Save Receiver 1's transaction info
		$ret['AdaptivePaymentsTransaction']['payKey'] = substr($key[28], strrpos($key[28], '=')+1, strlen($key[28]));
		$ret['AdaptivePaymentsTransaction']['adaptive_payment_id'] = $id;
		$ret['AdaptivePaymentsTransaction']['id'] = substr($key[14], strrpos($key[14], '=')+1, strlen($key[14]));
		$ret['AdaptivePaymentsTransaction']['transactionStatus'] = substr($key[8], strrpos($key[8], '=')+1, strlen($key[8]));
		$ret['AdaptivePaymentsTransaction']['amount'] = substr($key[9], strrpos($key[9], '=')+1, strlen($key[9]));
		$ret['AdaptivePaymentsTransaction']['email'] = urldecode(substr($key[10], strrpos($key[10], '=')+1, strlen($key[10])));
		$ret['AdaptivePaymentsTransaction']['primary'] = substr($key[11], strrpos($key[11], '=')+1, strlen($key[11]));
		$ret['AdaptivePaymentsTransaction']['refundAmount'] = substr($key[12], strrpos($key[12], '=')+1, strlen($key[12]));
		$ret['AdaptivePaymentsTransaction']['refundPending'] = substr($key[13], strrpos($key[13], '=')+1, strlen($key[13]));
		$ret['AdaptivePaymentsTransaction']['senderTransactionId'] = substr($key[14], strrpos($key[14], '=')+1, strlen($key[14]));
		$ret['AdaptivePaymentsTransaction']['senderTransactionsStatus'] = substr($key[15], strrpos($key[15], '=')+1, strlen($key[15]));
		return $ret; 
	}

	function receiver2TransactionInfoFromDetails($response,$id) {
		//parse the ap key from the response
		$key = explode("&",$response); //debug($key);exit;
		//Save Receiver 2's transaction info
		$ret['AdaptivePaymentsTransaction']['payKey'] = substr($key[28], strrpos($key[28], '=')+1, strlen($key[28]));
		$ret['AdaptivePaymentsTransaction']['adaptive_payment_id'] = $id;
		$ret['AdaptivePaymentsTransaction']['id'] = substr($key[23], strrpos($key[23], '=')+1, strlen($key[23]));
		$ret['AdaptivePaymentsTransaction']['transactionStatus'] = substr($key[17], strrpos($key[17], '=')+1, strlen($key[17]));
		$ret['AdaptivePaymentsTransaction']['amount'] = substr($key[18], strrpos($key[18], '=')+1, strlen($key[18]));
		$ret['AdaptivePaymentsTransaction']['email'] = urldecode(substr($key[19], strrpos($key[19], '=')+1, strlen($key[19])));
		$ret['AdaptivePaymentsTransaction']['primary'] = substr($key[20], strrpos($key[20], '=')+1, strlen($key[20]));
		$ret['AdaptivePaymentsTransaction']['refundAmount'] = substr($key[21], strrpos($key[21], '=')+1, strlen($key[21]));
		$ret['AdaptivePaymentsTransaction']['refundPending'] = substr($key[22], strrpos($key[22], '=')+1, strlen($key[22]));
		$ret['AdaptivePaymentsTransaction']['senderTransactionsStatus'] = substr($key[24], strrpos($key[24], '=')+1, strlen($key[24]));
		return $ret;
	}

	function AdaptivePayment2Receivers($paymentInfo=array()) {
		// inherit variables common with payment details
		$this->data ['BODY'] = $this->bodyCommon;
		//  Constants peculiar to payment
		$this->data ['BODY']['actionType'] = $this->adaptivePaymentConstants['BODY']['actionType'];
		$this->data ['BODY']['cancelUrl'] = $this->adaptivePaymentConstants['BODY']['cancelUrl'];
		$this->data ['BODY']['returnUrl'] = $this->adaptivePaymentConstants['BODY']['returnUrl'];
		$this->data ['BODY']['feesPayer'] = $this->adaptivePaymentConstants['BODY']['feesPayer'];
		
		$this->data ['HEADERS'] = $this->headersCommon;
		// From the form
		$this->data ['RECEIVER'] = $paymentInfo['RECEIVER'];
		$this->data ['BODY']['memo'] = $paymentInfo['BODY']['memo'];
		$this->data ['BODY']['senderEmail'] = $paymentInfo['BODY']['senderEmail'];
		// this is the value above with an internal number attached.
		$this->data ['BODY']['returnUrl'] = $paymentInfo['BODY']['returnUrl'];
		//set APAPI URL
		$url = trim($this->adaptivePaymentConstants['PAYPAL_URL_ADAPTIVE']);
		//Create request content
		$body_data = http_build_query($this->data['BODY'], '', chr(38));
		// receiver info built seperatly since the parse_ini_file() function won't read the syntax
		$receiver_data = '';
		foreach ($this->data['RECEIVER'] as $key => $value) {
			$num = substr($key, -1);
			$key = substr($key,0, strlen($key)-1);
			$receiver_data = $receiver_data . chr(38) . trim(sprintf("receiverList.receiver(%u).%s ",$num, $key)) . '=' . $value;
		}

		$body_data = $body_data . $receiver_data;
		/*
		 * TODO
		 * The request and the headers contain sample test data 
		 * Change the data with valid data applicable to your application
		 */
		try {
			//create request and add headers
			$params = array(
				'http' => array(
					'method' => "POST",
					'content' => $body_data,
					'header' =>  'Content-type: application/x-www-form-urlencoded'."\r\n".
						'X-PAYPAL-SECURITY-USERID: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-USERID'] . "\r\n" .
						'X-PAYPAL-REQUEST-DATA-FORMAT: ' . $this->data['HEADERS']['X-PAYPAL-REQUEST-DATA-FORMAT']. "\r\n" .
						'X-PAYPAL-RESPONSE-DATA-FORMAT: ' . $this->data['HEADERS']['X-PAYPAL-RESPONSE-DATA-FORMAT']. "\r\n" .
						'X-PAYPAL-SECURITY-PASSWORD: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-PASSWORD'] . "\r\n" .
						'X-PAYPAL-SECURITY-SIGNATURE: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-SIGNATURE']. "\r\n" .
						'X-PAYPAL-APPLICATION-ID: ' . $this->data['HEADERS']['X-PAYPAL-APPLICATION-ID']. "\r\n" .
						'CLIENT_AUTH: ' . $this->data['HEADERS']['CLIENT_AUTH']. "\r\n" .
						'X-PAYPAL-SERVICE-VERSION: ' . $this->data['HEADERS']['X-PAYPAL-SERVICE-VERSION']. "\r\n"
				)
			);
			//create stream context
			$ctx = stream_context_create($params);

			//open the stream and send request
			$fp = fopen($url, 'r', false, $ctx);
			//get response
			$response = stream_get_contents($fp);

			//check to see if stream is open
			if ($response === false) {
				throw new Exception("php error message = " . "$php_errormsg");
			}

			//close the stream
			fclose($fp);
			return $response;
		} catch(Exception $e) {
			echo 'Message: ||' .$e->getMessage().'||';
		}
	}

	function SyncWithPP ($paymentInfo) {
		// Constants peculiar to payment details
		// inherit variables common with payment details
		$this->data ['BODY'] = $this->bodyCommon;
		$this->data ['HEADERS'] = $this->headersCommon;
		//set APAPI URL
		$url = trim($this->adaptivePaymentDetailsConstants['PAYPAL_URL_ADAPTIVE']);
		$other_parms= array("payKey" => $paymentInfo[0]['AdaptivePayment']['payKey'],
				"senderEmail" => $paymentInfo[0]['AdaptivePayment']['senderEmail']
				);

		//Create request content
		$body_data = http_build_query($this->data['BODY'] + $other_parms, '', chr(38));
		/*
		 * TODO
		 * The request and the headers contain sample test data 
		 * Change the data with valid data applicable to your application
		 */
		try {
			//create request and add headers
			$params = array(
				'http' => array(
					'method' => "POST",
					'content' => $body_data,
					'header' =>  'Content-type: application/x-www-form-urlencoded'."\r\n".
						'X-PAYPAL-SECURITY-USERID: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-USERID'] . "\r\n" .
						'X-PAYPAL-REQUEST-DATA-FORMAT: ' . $this->data['HEADERS']['X-PAYPAL-REQUEST-DATA-FORMAT']. "\r\n" .
						'X-PAYPAL-RESPONSE-DATA-FORMAT: ' . $this->data['HEADERS']['X-PAYPAL-RESPONSE-DATA-FORMAT']. "\r\n" .
						'X-PAYPAL-SECURITY-PASSWORD: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-PASSWORD'] . "\r\n" .
						'X-PAYPAL-SECURITY-SIGNATURE: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-SIGNATURE']. "\r\n" .
						'X-PAYPAL-APPLICATION-ID: ' . $this->data['HEADERS']['X-PAYPAL-APPLICATION-ID']. "\r\n" .
						'CLIENT_AUTH: ' . $this->data['HEADERS']['CLIENT_AUTH']. "\r\n" .
						'X-PAYPAL-SERVICE-VERSION: ' . $this->data['HEADERS']['X-PAYPAL-SERVICE-VERSION']. "\r\n"
				)
			);
			//create stream context
			$ctx = stream_context_create($params);

			//open the stream and send request
			$fp = fopen($url, 'r', false, $ctx);
			//get response
			$response = stream_get_contents($fp);

			//check to see if stream is open
			if ($response === false) {
				throw new Exception("php error message = " . "$php_errormsg");
			}

			//close the stream
			fclose($fp);
			return $response;
			
		} catch(Exception $e) {
			echo 'Message: ||' .$e->getMessage().'||';
		}
	}

	function AdaptivePaymentDetails($paymentInfo=array()){
		// Constants peculiar to payment details
		// inherit variables common with payment details
		$this->data ['BODY'] = $this->bodyCommon;
		$this->data ['HEADERS'] = $this->headersCommon;
		//set APAPI URL
		$url = trim($this->adaptivePaymentDetailsConstants['PAYPAL_URL_ADAPTIVE']);
		$other_parms= array(
				"payKey" => $paymentInfo['AdaptivePayment']['payKey'],
				"senderEmail" => $paymentInfo['AdaptivePayment']['senderEmail']
		);

		//Create request content
		$body_data = http_build_query($this->data['BODY'] + $other_parms, '', chr(38));
		/*
		 * TODO
		 * The request and the headers contain sample test data 
		 * Change the data with valid data applicable to your application
		 */
		try {
			//create request and add headers
			$params = array(
				'http' => array(
					'method' => "POST",
					'content' => $body_data,
					'header' =>  'Content-type: application/x-www-form-urlencoded'."\r\n". 
						'X-PAYPAL-SECURITY-USERID: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-USERID'] . "\r\n" .
						'X-PAYPAL-REQUEST-DATA-FORMAT: ' . $this->data['HEADERS']['X-PAYPAL-REQUEST-DATA-FORMAT']. "\r\n" .
						'X-PAYPAL-RESPONSE-DATA-FORMAT: ' . $this->data['HEADERS']['X-PAYPAL-RESPONSE-DATA-FORMAT']. "\r\n" .
						'X-PAYPAL-SECURITY-PASSWORD: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-PASSWORD'] . "\r\n" .
						'X-PAYPAL-SECURITY-SIGNATURE: ' . $this->data['HEADERS']['X-PAYPAL-SECURITY-SIGNATURE']. "\r\n" .
						'X-PAYPAL-APPLICATION-ID: ' . $this->data['HEADERS']['X-PAYPAL-APPLICATION-ID']. "\r\n" .
						'CLIENT_AUTH: ' . $this->data['HEADERS']['CLIENT_AUTH']. "\r\n" .
						'X-PAYPAL-SERVICE-VERSION: ' . $this->data['HEADERS']['X-PAYPAL-SERVICE-VERSION']. "\r\n"
				)
			);
			//create stream context
			 $ctx = stream_context_create($params);

			//open the stream and send request
			$fp = fopen($url, 'r', false, $ctx);
			//get response
			$response = stream_get_contents($fp);

			//check to see if stream is open
			if ($response === false) {
				throw new Exception("php error message = " . "$php_errormsg");
			}

			//close the stream
			fclose($fp);
			return $response;
			
		} catch(Exception $e) {
			echo 'Message: ||' .$e->getMessage().'||';
		}
	}

	function APIError($errorNo,$errorMsg,$resArray) {
		$resArray['Error']['Number']=$errorNo;
		$resArray['Error']['Number']=$errorMsg;
		return $resArray;
	}

	function hash_call($methodName,$nvpStr) {
		require_once 'constants.php';
		
		$API_UserName=API_USERNAME;
		$API_Password=API_PASSWORD;
		$API_Signature=API_SIGNATURE;
		$API_Endpoint =API_ENDPOINT;
		$version=VERSION;
		
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		//Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		
		if (USE_PROXY) {
			curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT);
		}
		
		//NVPRequest for submitting to server
		$nvpreq="METHOD=".urlencode($methodName)."&VERSION=".urlencode($version)."&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature).$nvpStr;
		
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
		
		//getting response from server
		$response = curl_exec($ch);
		
		//convrting NVPResponse to an Associative Array
		$nvpResArray=$this->deformatNVP($response);
		$nvpReqArray=$this->deformatNVP($nvpreq);
		
		if (curl_errno($ch)) {
			$nvpResArray = $this->APIError(curl_errno($ch),curl_error($ch),$nvpResArray);
		} else {
			curl_close($ch);
		}
		
		return $nvpResArray;
	}

	/*
	 * This function will take NVPString and convert it to an Associative Array and it will decode the response.
	 * It is usefull to search for a particular key and displaying arrays.
	 * @nvpstr is NVPString.
	 * @nvpArray is Associative Array.
	 */
	function deformatNVP($nvpstr) {
		$intial=0;
		$nvpArray = array();
		
		while(strlen($nvpstr)) {
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
			
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
		}
		return $nvpArray;
	}

	function CreateRecurringPayments($paymentInfo=array()) {
		$firstName = urlencode($paymentInfo['Member']['first_name']);
		$lastName = urlencode($paymentInfo['Member']['last_name']);
		$email = urlencode($paymentInfo['Member']['email']);
		$creditCardType = urlencode($paymentInfo['CreditCard']['credit_type']);
		$creditCardNumber = urlencode($paymentInfo['CreditCard']['card_number']);
		$expDateMonth = urlencode($paymentInfo['CreditCard']['expiration_month']);
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		$expDateYear =urlencode($paymentInfo['CreditCard']['expiration_year']);
		$cvv2Number = urlencode($paymentInfo['CreditCard']['cv_code']);
		$address1 = urlencode($paymentInfo['Member']['billing_address']);
		$address2 = urlencode($paymentInfo['Member']['billing_address2']);
		$country = urlencode($paymentInfo['Member']['billing_country']);
		$city = urlencode($paymentInfo['Member']['billing_city']);
		$state = urlencode($paymentInfo['Member']['billing_state']);
		$zip = urlencode($paymentInfo['Member']['billing_zip']);
		
		$description = urlencode('DowntownFirst $16.00');
		$billingPeriod = urlencode(BILLINGPERIOD);
		$billingFrequency = urlencode(BILLINGFREQUENCY);
		$trialBillingPeriod = urlencode(TRIALBILLINGPERIOD);
		$trialBillingFrequency = urlencode(TRIALBILLINGFREQUENCY);
		$amt = urlencode(AMT);
		$trialAmt = urlencode(TRIALAMT);
		$failedInitAmtAction = urlencode("ContinueOnFailure");
		$autoBillAmt = urlencode("AddToNextBilling");
		$profileReference = urlencode("Anonymous");
		
		$currencyCode="USD";
		
		$startDate = urlencode(date('Y-m-d',time()+3600+24*30).'T00:00:00Z');
		
		$ip=$_SERVER['REMOTE_ADDR'];
		
		/*
		 * Construct the request string that will be sent to PayPal.
		 * The variable $nvpstr contains all the variables and is a
		 * name value pair string with & as a delimiter
		 */
		$nvpstr = "&EMAIL=$email&DESC=$description&IPADDRESS=$ip&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear;
		$nvpstr.= "&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&STREET2=$address2&CITY=$city&STATE=$state&ZIP=$zip";
		$nvpstr.= "&COUNTRYCODE=$country&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$startDate&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&AMT=$amt";
		$nvpstr.= '&AUTOBILLAMT='.$autoBillAmt.'&PROFILEREFERENCE='.$profileReference.'&FAILEDINITAMTACTION='.$failedInitAmtAction;
		$nvpstr.= "&TRIALBILLINGPERIOD=$trialBillingPeriod&TRIALBILLINGFREQUENCY=$trialBillingFrequency&TRIALAMT=$trialAmt&TRIALTOTALBILLINGCYCLES=1&MAXFAILEDPAYMENTS=1";
		
		/*
		 * Make the API call to PayPal, using API signature.
		 * The API response is stored in an associative array called $resArray
		 */
		$resArray = $this->hash_call("CreateRecurringPaymentsProfile",$nvpstr);
		
		/*
		 * Display the API response back to the browser.
		 * If the response from PayPal was a success, display the response parameters'
		 * If the response was an error, display the errors received using APIError.php.
		 */
		return $resArray;
		//Contains 'TRANSACTIONID,AMT,AVSCODE,CVV2MATCH, Or Error Codes'
	} 
}
?>
