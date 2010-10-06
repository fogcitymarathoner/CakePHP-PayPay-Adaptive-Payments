<?php //debug($this->data['AdaptivePaymentsTransaction']);exit;
	if (!isset($error)){
		if ($step==1){
			//debug($paramslist); 
			echo $form->create('adaptive_checkout',array('type' => 'post','action'=>'testpayment1/2'));
			?>
			<table>
					<tr><td colspan=2><h2>BODY</h2></td></tr>
					<?php
						foreach (array_keys($paramslist['BODY']) as $key): 
							echo $ekopp->printinirow($key,$paramslist['BODY'][$key],'edit','BODY');
						endforeach;
					?>
					<tr><td colspan=2><h2>RECEIVER</h2></td></tr>
					<?php
						foreach (array_keys($paramslist['RECEIVER']) as $key): 
							echo $ekopp->printinirow($key,$paramslist['RECEIVER'][$key],'edit','RECEIVER');
						endforeach;
					?>
			</table>
					<?php //$elementName = 'X-PAYPAL-REQUEST-DATA-FORMAT'; ?>
			
					<?php //echo $ekopp->printinirow($elementName,$paramslist['HEADERS'][$elementName], 'ro') ?>
					<?php //echo $ekopp->printinirow($elementName,$paramslist['HEADERS'][$elementName]) ?>
						

			<?php echo $form->end('Confirm Payment'); 	?>		
			
<?php			
		}
		if ($step==2){
			// Should never be called.
		}
		if ($step==3){
			// Checkout complete
			echo '<h2>Checkout complete! Thank You!</h2>';
			echo 'Sender:<br>'.$this->data['AdaptivePayment']['senderEmail'];
			echo '<br><br>Receiver 1<br>';
			echo 'email: '.$this->data['AdaptivePaymentsTransaction'][0]['email'].'<br>';
			echo 'amount: '.$this->data['AdaptivePaymentsTransaction'][0]['amount'].'<br>';
			echo 'status: '.$this->data['AdaptivePaymentsTransaction'][0]['transactionStatus'].'<br>';
			echo '<br>Receiver 2<br>';
			echo 'email: '.$this->data['AdaptivePaymentsTransaction'][1]['email'].'<br>';
			echo 'amount: '.$this->data['AdaptivePaymentsTransaction'][1]['amount'].'<br>';
			echo 'status: '.$this->data['AdaptivePaymentsTransaction'][1]['transactionStatus'].'<br>';
		}
	}
	else
		echo $error;
?>