<?php
class AdaptivePaymentsTransaction extends AppModel {

	var $name = 'AdaptivePaymentsTransaction';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'AdaptivePayment' => array('className' => 'AdaptivePayment',
								'foreignKey' => 'adaptive_payment_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
}
?>