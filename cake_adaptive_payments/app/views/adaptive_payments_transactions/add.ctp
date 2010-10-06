<div class="adaptivePaymentsTransactions form">
<?php echo $form->create('AdaptivePaymentsTransaction');?>
	<fieldset>
 		<legend><?php __('Add AdaptivePaymentsTransaction');?></legend>
	<?php
		echo $form->input('payKey');
		echo $form->input('transactionId');
		echo $form->input('transactionStatus');
		echo $form->input('amount');
		echo $form->input('email');
		echo $form->input('primary');
		echo $form->input('refundAmount');
		echo $form->input('pendingRefund');
		echo $form->input('senderTransactionId');
		echo $form->input('senderTransactionsStatus');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List AdaptivePaymentsTransactions', true), array('action' => 'index'));?></li>
	</ul>
</div>
