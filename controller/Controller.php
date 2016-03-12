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
		$size = $this->model->getSize();
		foreach($cards as $index => $card) {
			$ct = $count[$index+1];
			// trim 5+ copies to 4 in 60-card
			if($size == 60 && $ct > 4) {
				$ct = 4;
			}
			for($i=0;$i<$ct;$i++) {
				//add cards to pool
				$this->model->addToPool($card);
			}
		}
	}

	// turn pool into a deck!
	public function processPool($p) {
		$p = $this->filterColor($p);
		$p = $this->filterBasics($p);
		return $p;
	}

	// filter the pool by color
	public function filterColor($p) {
		$colorPool = array();
		// for each card in pool...
		foreach($p as $card) {
			// if card has no color ID, add it to colorPool
			if($card->getColors() == null) {
				$colorPool[] = $card;
			} else {
				// for each color of card...
				foreach($card->getColors() as $cardCol) {
					// for each color selected...
					foreach($this->model->getColors() as $selCol) {
						// add card to colorPool if there is a color match!
						if($cardCol == $selCol) {
							$colorPool[] = $card;
							break 2;
						}						
					}
				}
			}
		}
		return $colorPool;
	}

	// remove (main 5) basic lands, since we'll be adding them ourselves
	public function filterBasics($p) {
		// for each card in pool...
		foreach($p as $index => $card) {
			// drop basics
			switch($card->getName()) {
				case "Plains":
				case "Island":
				case "Swamp":
				case "Mountain":
				case "Forest":
					unset($p[$index]);
					break;
			}
		}
		return $p;
	}
}

?>
