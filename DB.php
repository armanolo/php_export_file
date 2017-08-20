<?php

/**
 * User: Manuel Martin
 * Date: 19/08/17
 * Project: Task
 * Task(c) 2017
 */

class DB {

	public $listOffers = null;


	/**
	 * Get list offers
	 */
	public function getListOffers(){
		return $this->listOffers;
	}

    //Contructor
    public function __construct() {
    	$listTempOffers = array();
    	$names = array('Waylon Dalton','Justine Henderson','Abdullah Lang','Marcus Cruz','Thalia Cobb','Mathias Little');
    	//get date
    	$date = new DateTime();

    	//Create offers
    	for($i = 0;$i<count($names);$i++)
    	{
    		array_push($listTempOffers, $this->getOffer(($i+1),$names[$i],$date));
    	}
    	$this->listOffers = $listTempOffers;
    }

	/**
	 * Create offer
	 * @param int $id
	 * @param string $name
	 */
	private function getOffer($id, $name, $date){
		$arrayValue = array();
		//Id
		$arrayValue[] = $id;
		//Name
		$arrayValue[] = $name;
		//Date
		$date->sub(new DateInterval('P1D'));
		$arrayValue[] = $date->format('Y-m-d');
		//Money
		$money = rand ( 100, 1000);
		$arrayValue[] = $money;
		return $arrayValue;
	}

}

