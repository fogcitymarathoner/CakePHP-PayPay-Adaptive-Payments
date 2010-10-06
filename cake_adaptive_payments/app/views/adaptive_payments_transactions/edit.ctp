<div class="adaptivePaymentsTransactions form">
<?php echo $form->create('AdaptivePaymentsTransaction');?>
	<fieldset>
 		<legend><?php __('Edit AdaptivePaymentsTransaction');?></legend>
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
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('AdaptivePaymentsTransaction.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('AdaptivePaymentsTransaction.id'))); ?></li>
		<li><?php echo $html->link(__('List AdaptivePaymentsTransactions', true), array('action' => 'index'));?></li>
	</ul>
</div>
