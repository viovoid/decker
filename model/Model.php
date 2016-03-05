<?php

include_once("model/Card.php");

class Model {
	public function getSetCardList() {

		$set = "BFZ";
		$rawJson = file_get_contents("/srv/http/decker/json/" . $set . ".json");
		$json = json_decode($rawJson, true);
		$jsonCards = $json["cards"];



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
	
	public function getCard($index) {
		// we use the previous function to get all the books and then we return the requested one.
		// in a real life scenario this will be done through a db select command
		$allCards = $this->getSetCardList();
		return $allCards[$index];
	}

}

?>
