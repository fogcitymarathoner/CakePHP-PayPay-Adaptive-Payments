<div class="adaptivePayments index">
<h2><?php __('AdaptivePayments');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>

	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('payKey');?></th>
	<th><?php echo $paginator->sort('created_date');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th><?php echo $paginator->sort('memo');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($adaptivePayments as $adaptivePayment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $adaptivePayment['AdaptivePayment']['id']; ?>
		</td>
		<td>
			<?php echo $adaptivePayment['AdaptivePayment']['payKey']; ?>
		</td>
		<td>
			<?php echo $adaptivePayment['AdaptivePayment']['created_date']; ?>
		</td>
		<td>
			<?php echo $adaptivePayment['AdaptivePayment']['status']; ?>
		</td>
		<td>
			<?php echo $adaptivePayment['AdaptivePayment']['memo']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Sync/View', true), array('action' => 'view', $adaptivePayment['AdaptivePayment']['id'])); ?>
		</td>
	</tr>
	<tr<?php echo $class;?>>
	<td colspan=6>
	        <?php if ($adaptivePayment['AdaptivePayment']['status']=='COMPLETED'){ ?>
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
	</td>
	</tr>
	
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New AdaptivePayment', true), array('action' => 'add')); ?></li>
	</ul>
</div>
