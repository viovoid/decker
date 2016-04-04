<?php

include_once("model/Card.php");

class Model {

	protected $cards = array();
	protected $pool = array();
	protected $size = 0;
	protected $colors = array();

	public function getSetCardList() {

		// we'll hardcode the set for now
		$set = "SOI";
		// XXX: this should be made a relative path
		$rawJson = file_get_contents("/srv/http/decker/json/" . $set . ".json");
		$json = json_decode($rawJson, true);
		$jsonCards = $json["cards"];


		//make our cards
		$cards = array();
        foreach($jsonCards as $jsonCard) {
            $cards[] = new Card($jsonCard["number"],
                                $jsonCard["name"],
                                $jsonCard["colorIdentity"],
								$jsonCard["manaCost"],
                                $jsonCard["cmc"],
                                $jsonCard["rarity"],
                                $jsonCard["types"]);
		}

		return $cards;
	}
	
	/* XXX: rewrite this to not parse json every time.
			store list as array in class. */
	public function getCard($index) {
		$allCards = $this->getSetCardList();
		return $allCards[$index];
	}

	// add a single card to pool
	public function addToPool($card) {
		$this->pool[] = $card;
	}

	public function getPool() {
		return $this->pool;
	}
	
	public function setSize($s) {
		$this->size = $s;
	}

	public function getSize() {
		return $this->size;
	}

	public function setColors($c) {
		$this->colors = $c;
	}

	public function getColors() {
		return $this->colors;
	}
}

?>
