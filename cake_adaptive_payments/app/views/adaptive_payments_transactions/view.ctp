<div class="adaptivePaymentsTransactions view">
<h2><?php  __('AdaptivePaymentsTransaction');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('PayKey'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['payKey']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('TransactionId'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['transactionId']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('TransactionStatus'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['transactionStatus']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Primary'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['primary']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('RefundAmount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['refundAmount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('PendingRefund'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['pendingRefund']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('SenderTransactionId'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['senderTransactionId']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('SenderTransactionsStatus'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['senderTransactionsStatus']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit AdaptivePaymentsTransaction', true), array('action' => 'edit', $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete AdaptivePaymentsTransaction', true), array('action' => 'delete', $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $adaptivePaymentsTransaction['AdaptivePaymentsTransaction']['id'])); ?> </li>
		<li><?php echo $html->link(__('List AdaptivePaymentsTransactions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New AdaptivePaymentsTransaction', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
