<?php

class Card {
	public $index;
	public $name;
	public $colorIDs;
	public $manaCost;
	public $cmc;
	public $rarity;
	public $cardType;
	
	public function __construct($index, $name, $colorIDs, $manaCost, $cmc, $rarity, $cardType) {  
        $this->index = $index;
	    $this->name = $name;
	    $this->colorIDs = $colorIDs;
		$this->manaCost = $manaCost;
	    $this->cmc = $cmc;
	    $this->rarity = $rarity;
	    $this->cardType = $cardType;
    } 

	public function getName() {
		return $this->name;
	}

	public function getColors() {
		return $this->colorIDs;
	}

	public function getManaCost() {
		return $this->manaCost;
	}

	public function getCMC() {
		return $this->cmc;
	}

	public function getCardTypes() {
		return $this->cardType;
	}
}

?>
