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

		$pool = $this->processPool($pool);

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

		$cardCount = count($p);
		$avgCMC = $this->averageCMC($p);

		// trim a card until we hit the sweet spot
		$isSaturated = false;
		while(!$isSaturated) {
			$nonLandCount = $this->countNonLands($p);
			if(($this->model->getSize() == 60 && $nonLandCount >= 38)
			|| ($this->model->getSize() == 40 && $nonLandCount >= 22)) {
				$p = $this->trim($p);
			} else {
				$isSaturated = true;
			}
		}
		$p = $this->addBasics($p);
		return $p;
	}

	// filter the pool by color
	public function filterColor($p) {
		// for each card in pool...
		foreach($p as $index => $card) {
			// for each color of card...
			foreach($card->getColors() as $cardCol) {
				$r = 0;
				// for each color selected...
				foreach($this->model->getColors() as $selCol) {
					// if color is selected, the card stays
					if($cardCol == $selCol) {
						$r = 1;
					}
				}
				// remove card if it has a color not selected
				if($r == 0) {
					unset($p[$index]);
				}
			}
		}
		return $p;
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

	// average converted mana cost in pool
	public function averageCMC($p) {
		$total = 0;
		foreach($p as $card) {
			$total += $card->getCMC();
		}
		return ($total /= count($p));
	}

	// count nonland cards in pool
	public function countNonLands($p) {
		foreach($p as $index => $card) {
			$types = $card->getCardTypes();
			foreach($types as $type) {
				if($type == "Land") {
					unset($p[$index]);
				}
			}
		}
		return count($p);
	}

	// remove a card
	public function trim($p) {
		// give us 17 0s, since max cost as of now is 16
		// (not counting Gleemax, of course)
		for($c=0;$c<=16;$c++) {
			$cmcList[] = 0;
		}
		// count cards by cmc
		//XXX: this probably doesn't need to be done every time...
		//     move out of function?
		foreach($p as $index => $card) {
			$cmcCounts[$card->getCMC()]++;
		}

		// get highest cmc with the most cards
		$maxCMC = max(array_keys($cmcCounts, max($cmcCounts)));

		// go through cards, cut one with highest, most populated cmc
		//XXX: do this more methodically? perhaps go by rarity?
		foreach($p as $index => $card) {
			if($card->getCMC() == $maxCMC) {
				unset($p[$index]);
				break;
			}
		}
		return $p;
	}

	// add basic lands
	public function addBasics($p) {
		//total mana symbols so we can find the right split
		$manaSymbols = $this->countManaSymbols($p);
		$landSlots = $this->model->getSize() - count($p);
		$basicsCount = $this->calcBasics($manaSymbols, $landSlots);

		//actually add the basics to pool
		//XXX: do something about wastes
		for($i=0;$i<$basicsCount["W"];$i++) $p[] = new Card(0, "Plains", "W", 0, 0, "B", "Basic Land");
		for($i=0;$i<$basicsCount["U"];$i++) $p[] = new Card(0, "Island", "U", 0, 0, "B", "Basic Land");
		for($i=0;$i<$basicsCount["B"];$i++) $p[] = new Card(0, "Swamp", "B", 0, 0, "B", "Basic Land");
		for($i=0;$i<$basicsCount["R"];$i++) $p[] = new Card(0, "Mountain", "R", 0, 0, "B", "Basic Land");
		for($i=0;$i<$basicsCount["G"];$i++) $p[] = new Card(0, "Forest", "G", 0, 0, "B", "Basic Land");
		return $p;
	}

	//count total mana symbols per color in pool
	public function countManaSymbols($p) {
		//XXX: if adding other sets, add phyrexian/snow/etc
			$symbols = array("C"=>0,
							"W"=>0,
							"U"=>0,
							"B"=>0,
							"R"=>0,
							"G"=>0);
		foreach($p as $card) {
			$symbols["C"] += substr_count($card->getManaCost(), "C");
			$symbols["W"] += substr_count($card->getManaCost(), "W");
			$symbols["U"] += substr_count($card->getManaCost(), "U");
			$symbols["B"] += substr_count($card->getManaCost(), "B");
			$symbols["R"] += substr_count($card->getManaCost(), "R");
			$symbols["G"] += substr_count($card->getManaCost(), "G");
		}
		return $symbols;
	}

	//determine basics split from mana symbols
	public function calcBasics($manaSymbols, $landCount) {
		$totalSymbols = array_sum($manaSymbols);
		$basics["C"] = round($manaSymbols["C"] / $totalSymbols * $landCount);
		$basics["W"] = round($manaSymbols["W"] / $totalSymbols * $landCount);
		$basics["U"] = round($manaSymbols["U"] / $totalSymbols * $landCount);
		$basics["B"] = round($manaSymbols["B"] / $totalSymbols * $landCount);
		$basics["R"] = round($manaSymbols["R"] / $totalSymbols * $landCount);
		$basics["G"] = round($manaSymbols["G"] / $totalSymbols * $landCount);
		return $basics;
	}
	
}

?>
