<?php

class AppController extends Controller {

	function beforeFilter() {
		Configure::write('myinstallpath', FULL_BASE_URL. $this->base);
	}
}

?>
