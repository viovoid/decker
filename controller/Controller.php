<?php
include_once("model/Model.php");

class Controller {
	public $model;
	
	public function __construct() {  
        $this->model = new Model();

    } 
	
	public function invoke() {
		// card not clicked
		if (!isset($_GET['card']))
		{
			// if no card specified, return all cards
			$cards = $this->model->getSetCardList();
			include 'view/cardlist.php';
		}
		// on card clicked
		else if(isset($_GET['card'])) {
			// show the requested card, if specified
			$card = $this->model->getCard($_GET['card']);
			include 'view/viewcard.php';
		}
	}

	// on pool submit
	public function submit() {
		$size = $_POST["size"];
		echo $size;
		$pool = $this->makePool();
		include 'view/test.php';
	}

	public function makePool() {
		$cards = $this->model->getSetCardList();
		foreach($cards as $index => $card) {
			$ct = $_POST["count"][$index];
			for($i=0;$i<$ct;$i+=1) {
				$pool[] = $card;
			}
		}
	}

}

?>
