<?php
class AdaptivePaymentsController extends AppController {

	var $name = 'AdaptivePayments';
	var $helpers = array('Html', 'Form');
	var $paginate = array('limit' => 50, 'page' => 1,"order" => 'created_date DESC');
	var $components = array('PaypalAdaptive');

	function index() {
		$this->AdaptivePayment->recursive = 1;
		$this->set('adaptivePayments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AdaptivePayment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->data = $this->AdaptivePayment->read(null, $id);
		$response = $this->PaypalAdaptive->processPayment($this->data,"AdaptivePaymentDetails");
	    if ($this->data['AdaptivePayment']['status']!='PENDING'){
		#update payment status
		$key = explode("&",$response); 
		//debug($key);exit;
		$this->data['AdaptivePayment']['status'] = substr($key[15], strrpos  ( $key[15]  ,  '=')+1,strlen($key[15]));
		//debug($this->data);exit;
		$this->AdaptivePayment->save($this->data);
		// If in created state, nothing to report, no change in seller status
		if($this->data['AdaptivePayment']['status']!='CREATED')
		{
			$trans1 = $this->PaypalAdaptive->receiver1TransactionInfoFromDetails($response,$id);
			$trans1['AdaptivePaymentsTransaction']['id'] = $this->data['AdaptivePaymentsTransaction'][0]['id'];
			$this->AdaptivePayment->AdaptivePaymentsTransaction->save($trans1);
			
			$trans2 = $this->PaypalAdaptive->receiver2TransactionInfoFromDetails($response,$id);
			$trans2['AdaptivePaymentsTransaction']['id'] = $this->data['AdaptivePaymentsTransaction'][1]['id'];
			$this->AdaptivePayment->AdaptivePaymentsTransaction->save($trans2);
			
		}
		// Pickup newly created receiver transactions
		$this->data = $this->AdaptivePayment->read(null, $id);
	        }
		$this->set('adaptivePayment', $this->data);
	}
}
?>