<?php
class AdaptiveCheckoutsController extends AppController {

	var $name = 'AdaptiveCheckouts';
	var $paginate = array('limit' => 50, 'page' => 1,"order" => 'first ASC');
	var $uses = array('AdaptivePayment');
	var $components = array('PaypalAdaptive');

	function beforeFilter() {
		parent::BeforeFilter();
		$this->helpers = array('Html', 'Form', 'Javascript', 'Ajax','Ekopp');
		$this->Auth->allowedActions = array('*', );
	}

	function index() {
	}

	function testpayment1($step=1,$id=null) {
		//$this->Ssl->force();
		$this->AdaptivePayment->recursive = 1;
		$this->set('step',$step);
		// Get user inputs
		if ($step == 1) {
			// Prefill form with test data I know works over and over
			$paramslist =
				Array
				(
					'BODY' => Array
						(
							'memo' => 'testing Eko payments',
							'senderEmail' => 'ekotab_1266786870_per@fogtest.com',
						),
				
					'RECEIVER' => Array
						(
							'amount0' => 15.63,
							//'email0' => 'ekotab_1266785409_per@fogtest.com',
							'email0' => 'ekotab_1266785409_per@fogtest.com',
							'primary0' => false,
							'amount1' => 1.37,
							'email1' => 'ekotab_1266785372_per@fogtest.com',
							'primary1' => false,
						)
				);
			$this->set(compact('paramslist'));
		}
		// Get Transaction from PayPal
		elseif ($step == 2){
			srand((double) microtime( )*10000000);
			$random_number = rand(1000000, 10000000);
			$this->data['BODY']['returnUrl'] = $this->PaypalAdaptive->getReturnURL().$random_number;
			$this->data['BODY']['cancelUrl'] = $this->PaypalAdaptive->getCancelURL().$random_number;
			$response = $this->PaypalAdaptive->processPayment($this->data,"AdaptivePayment2Receivers");

			//parse the ap key from the response
			$key = explode("&",$response); 
			$month = date('m');
			$day = date('d');
			$year = date('Y');
			$hour = date('h');
			$min = date('i');
			$meridian = date('a');
			$currentTime = array(
				'month'=>$month,
				'day' => $day,
				'year' => $year,
				'hour' => $hour,
				'min' => $min,
				'meridian' => $meridian
			);
			$payment = array();
			$payment = array(
					'id' => $random_number,
					'timestamp' => substr($key[0], strrpos($key[0], '=')+1, strlen($key[0])),
					'ack' => substr($key[1], strrpos($key[1], '=')+1, strlen($key[1])),
					'correlation_id' => substr($key[2], strrpos($key[2], '=')+1, strlen($key[2])),
					'build' => substr($key[3], strrpos($key[3], '=')+1, strlen($key[3])),
					'payKey' => substr($key[4], strrpos($key[4], '=')+1, strlen($key[4])),
					'payment_exec_status' => substr($key[5], strrpos($key[5], '=')+1, strlen($key[5])),
					'memo' => $this->data['BODY']['memo'],
					'senderEmail' => $this->data['BODY']['senderEmail'],
					'returnUrl' => $this->data['BODY']['returnUrl'],
					'cancelUrl' => $this->data['BODY']['cancelUrl'],
					'amount0' => $this->data['RECEIVER']['amount0'],
					'email0' => $this->data['RECEIVER']['email0'],
					'primary0' => $this->data['RECEIVER']['primary0'],
					'amount1' => $this->data['RECEIVER']['amount1'],
					'email1' => $this->data['RECEIVER']['email1'],
					'primary1' => $this->data['RECEIVER']['primary1'],
					'created_date' => $currentTime,
					'status' => 'PENDING',
			);

			$this->data['AdaptivePayment'] = $payment;
			$this->AdaptivePayment->create();
			$this->AdaptivePayment->save($this->data);
			
			if( $key[1] == 'responseEnvelope.ack=Success') {
				// Things are setup for check out at PayPal
				header('Location: '.str_replace("payKey", "paykey", $this->PaypalAdaptive->getPaypalApprovePaymentURL() . $key[4]));
			} else {
				echo 'ERROR: ' . $key[4].'<br>';
				echo 'MESSAGE: ' . $key[8];
			}
		}
		elseif ($step == 3) {
			// This is the return URL for a good checkout back from PayPal
			if ($id) {
				$this->data = $this->AdaptivePayment->read(null, $id);
				$response = $this->PaypalAdaptive->processPayment($this->data,"AdaptivePaymentDetails");
				//debug($response);exit;
				#update payment status
				$key = explode("&",$response); 
				$this->data['AdaptivePayment']['status'] = substr($key[27], strrpos($key[27], '=')+1, strlen($key[27]));

				$this->AdaptivePayment->save($this->data);
//debug($key)	;
//debug($this->PaypalAdaptive->receiver1TransactionInfoFromDetails($response,$id));
//debug($this->PaypalAdaptive->receiver2TransactionInfoFromDetails($response,$id));	exit;		
				$this->AdaptivePayment->AdaptivePaymentsTransaction->create();
				$this->AdaptivePayment->AdaptivePaymentsTransaction->save
				($this->PaypalAdaptive->receiver1TransactionInfoFromDetails($response,$id));
			
				
				$this->AdaptivePayment->AdaptivePaymentsTransaction->create();
				$this->AdaptivePayment->AdaptivePaymentsTransaction->save
				($this->PaypalAdaptive->receiver2TransactionInfoFromDetails($response,$id));
			
				// Pickup newly created receiver transactions
				//debug($this->AdaptivePayment->read(null, $id));exit;
				$this->data = $this->AdaptivePayment->read(null, $id);
				$this->set('adaptivePayment', $this->data);
			} else {
				$this->Session->setFlash(__('Null Payment ID.', true));
	 		}
		}
	}

	// this function is part of the cancel URL but never gets called by Paypal
	function cancel($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AdaptivePayment', true));
			$this->redirect(array('action' => 'index'));
		}
		/*if ($this->AdaptivePayment->del($id)) {
			$this->Session->setFlash(__('AdaptivePayment deleted', true));
			$this->redirect(array('action' => 'index'));
		}*/
		$this->data = $this->AdaptivePayment->read(null, $id);
		$this->Session->setFlash(__('The AdaptivePayment could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}
	
 }
?>