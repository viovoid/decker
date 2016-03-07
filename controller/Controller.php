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
			include 'view/form.php';
		}
		// on card clicked
		// XXX: this is going away, and the whole method refactored
		else if(isset($_GET['card'])) {
			// show the requested card, if specified
			$card = $this->model->getCard($_GET['card']);
			include 'view/card.php';
		}
	}

	// on pool submit
	public function submit() {
		// get our POST vars
		$this->model->setSize($_POST["size"]);
		$this->model->setColors($_POST["colors"]);
		// generate pool
		$this->makePool();

		// get the one we made
		$pool = $this->model->getPool();
		$size = $this->model->getSize();
		$colors = $this->model->getColors();

		$colorPool = $this->processPool($pool);

		include 'view/pool.php';
	}

	// populate pool
	public function makePool() {
		$cards = $this->model->getSetCardList();
		$count = $_POST["count"];
		foreach($cards as $index => $card) {
			$ct = $count[$index+1];
			for($i=0;$i<$ct;$i++) {
				//add cards to pool
				$this->model->addToPool($card);
			}
		}
	}

	// turn pool into a deck!
	public function processPool($p) {
		$colorPool = $this->filterColor($p);
	}

	// filter the pool by color
	public function filterColor($p) {
		$colorPool = array();
		// for each card in pool...
		foreach($p as $card) {
			// for each color of card
			foreach($card->getColors() as $cardCol) {
				//for each color selected
				foreach($this->model->getColors() as $selCol) {
//echo $cardCol . $selCol."<br>";
					/*if($cardCol == $selCol)*/ {
						$colorPool[] = $card;
						break 2;
					}						
				}
			}
		}
		return $colorPool;
	}

}

?>
