<div class="adaptivePaymentsTransactions index">
<h2><?php __('AdaptivePaymentsTransactions');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('payKey');?></th>
	<th><?php echo $paginator->sort('transactionId');?></th>
	<th><?php echo $paginator->sort('transactionStatus');?></th>
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('primary');?></th>
	<th><?php echo $paginator->sort('refundAmount');?></th>
	<th><?php echo $paginator->sort('pendingRefund');?></th>
	<th><?php echo $paginator->sort('senderTransactionId');?></th>
	<th><?php echo $paginator->sort('senderTransactionsStatus');?></th>
	<!--<th class="actions"><?php __('Actions');?></th>-->
</tr>
<?php
$i = 0;
foreach ($adaptivePaymentsTransactions as $adaptivePaymentsTransaction):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['payKey']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['transactionId']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['transactionStatus']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['amount']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['email']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['primary']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['refundAmount']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['pendingRefund']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['senderTransactionId']; ?>
		</td>
		<td>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['senderTransactionsStatus']; ?>
		</td>
		<!--
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id'])); ?>
		</td>
		-->
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<!--
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New AdaptivePaymentsTransaction', true), array('action' => 'add')); ?></li>
	</ul>
</div>
-->
