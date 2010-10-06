<?php
class SyncShell extends Shell {
	var $uses = array('AdaptivePayment','AdaptivePaymentsTransaction');
	function main() {
		App::import('Component', 'PaypalAdaptive'); 
		$this->data = $this->AdaptivePayment->find('all',array('conditions'=>array('status'=>array('PENDING','CREATED'))));
		$ppcomp = new PaypalAdaptiveComponent;
		foreach ($this->data as $payment): 
			$response = $ppcomp->processPayment($this->data,"SyncWithPP");
			$key = explode("&",$response); 
			$this->out(var_export($key));
			$this->out(var_export($payment));
			$this->out(var_export($payment['AdaptivePayment']['id']));
			$payment['AdaptivePayment']['status'] = substr($key[15], strrpos  ( $key[15]  ,  '=')+1,strlen($key[15]));
			$this->AdaptivePayment->save($payment);
			debug($key);debug($payment);
			$trans1= $ppcomp->receiver1TransactionInfoFromDetails($response,$payment['AdaptivePayment']['id']);
			$trans2= $ppcomp->receiver2TransactionInfoFromDetails($response,$payment['AdaptivePayment']['id']);
			debug($trans1);
			debug($trans2);
			if ($payment['AdaptivePayment']['status'] != 'EXPIRED' && $payment['AdaptivePayment']['status'] != 'CREATED')
			{		
				$this->AdaptivePayment->AdaptivePaymentsTransaction->create();
				$this->AdaptivePayment->AdaptivePaymentsTransaction->save($trans1);
				$this->AdaptivePayment->AdaptivePaymentsTransaction->create();
				$this->AdaptivePayment->AdaptivePaymentsTransaction->save($trans2);
			}
		endforeach;
	}
}
?>