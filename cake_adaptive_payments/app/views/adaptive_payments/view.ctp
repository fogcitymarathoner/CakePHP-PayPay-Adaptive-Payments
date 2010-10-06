<div class="adaptivePayments view">
<h2><?php  __('AdaptivePayment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Timestamp'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['timestamp']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ack'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['ack']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Correlation Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['correlation_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Build'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['build']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pay Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['payKey']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Payment Exec Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['payment_exec_status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Memo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['memo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('SenderEmail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['senderEmail']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('ReturnUrl'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['returnUrl']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('CancelUrl'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['cancelUrl']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount0'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['amount0']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email0'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['email0']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Primary0'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['primary0']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['amount1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['email1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Primary1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['primary1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $adaptivePayment['AdaptivePayment']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

	        <?php if ($adaptivePayment['AdaptivePayment']['status']!='PENDING'){ ?>
			<?php echo 'Sender: '.$adaptivePayment['AdaptivePayment']['senderEmail'].'<br>'; ?>
			<?php echo 'Receiver1: '.$adaptivePayment['AdaptivePayment']['email0'].' '; ?>
			<?php echo $adaptivePayment['AdaptivePayment']['amount0'].'<br>'; ?>
			<?php echo 'Receiver2: '.$adaptivePayment['AdaptivePayment']['email1'].' '; ?>			
			<?php echo $adaptivePayment['AdaptivePayment']['amount1']; ?>
			<?php 
						echo '<br><br>Receiver 1<br>';
			echo 'email: '.$adaptivePayment['AdaptivePaymentsTransaction'][0]['email'].'<br>';
			echo 'amount: '.$adaptivePayment['AdaptivePaymentsTransaction'][0]['amount'].'<br>';
			echo 'status: '.$adaptivePayment['AdaptivePaymentsTransaction'][0]['transactionStatus'].'<br>';
			echo '<br>Receiver 2<br>';
			echo 'email: '.$adaptivePayment['AdaptivePaymentsTransaction'][1]['email'].'<br>';
			echo 'amount: '.$adaptivePayment['AdaptivePaymentsTransaction'][1]['amount'].'<br>';
			echo 'status: '.$adaptivePayment['AdaptivePaymentsTransaction'][1]['transactionStatus'].'<br>';
			}
			?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List AdaptivePayments', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
