<?php
class AdaptivePayment extends AppModel {

	var $name = 'AdaptivePayment';
	var $validate = array(
		'senderEmail' => array('email'),
		'amount0' => array('money'),
		'email0' => array('email'),
		'amount1' => array('money'),
		'email1' => array('email')
	);
	var $hasMany = array(
			'AdaptivePaymentsTransaction' => array('className' => 'AdaptivePaymentsTransaction',
								'foreignKey' => 'adaptive_payment_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
	);
	
}
?>