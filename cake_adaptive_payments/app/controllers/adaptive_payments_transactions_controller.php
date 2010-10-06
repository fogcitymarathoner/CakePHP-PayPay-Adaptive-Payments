<?php
class AdaptivePaymentsTransactionsController extends AppController {

	var $name = 'AdaptivePaymentsTransactions';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->AdaptivePaymentsTransaction->recursive = 0;
		$this->set('adaptivePaymentsTransactions', $this->paginate());
	}

	/*
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AdaptivePaymentsTransaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('adaptivePaymentsTransaction', $this->AdaptivePaymentsTransaction->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->AdaptivePaymentsTransaction->create();
			if ($this->AdaptivePaymentsTransaction->save($this->data)) {
				$this->Session->setFlash(__('The AdaptivePaymentsTransaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The AdaptivePaymentsTransaction could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AdaptivePaymentsTransaction', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->AdaptivePaymentsTransaction->save($this->data)) {
				$this->Session->setFlash(__('The AdaptivePaymentsTransaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The AdaptivePaymentsTransaction could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AdaptivePaymentsTransaction->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AdaptivePaymentsTransaction', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->AdaptivePaymentsTransaction->del($id)) {
			$this->Session->setFlash(__('AdaptivePaymentsTransaction deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The AdaptivePaymentsTransaction could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}
	*/

}
?>