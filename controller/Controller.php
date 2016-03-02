<?php
include_once("model/Model.php");

class Controller {
	public $model;
	
	public function __construct()  
    {  
        $this->model = new Model();

    } 
	
	public function invoke()
	{
		if (!isset($_GET['card']))
		{
			// if no card specified, return all cards
			$cards = $this->model->getSetCardList();
			include 'view/cardlist.php';
		}
		else
		{
			// show the requested card, if specified
			$card = $this->model->getCard($_GET['card']);
			include 'view/viewcard.php';
		}
	}
}

?>
