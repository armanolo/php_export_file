<?php

/**
 * User: Manuel Martin
 * Date: 19/08/17
 * Project: Task
 * Task(c) 2017
 */

class ExportFile {
	private $type = null;
	private $listId = null;
	private $listName = null;
	private $listDate = null;
	private $listMoney = null;

    /**
     * type
     * @return unkown
     */
    public function getType(){
        return $this->type;
    }

    /**
     * type
     * @param unkown $type
     * @return ExportFile
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }

    /**
     * listId
     * @return unkown
     */
    public function getListId(){
        return $this->listId;
    }

    /**
     * listId
     * @param unkown $listId
     * @return ExportFile
     */
    public function setListId($listId){
        $this->listId = $listId;
        return $this;
    }

    /**
     * listName
     * @return unkown
     */
    public function getListName(){
        return $this->listName;
    }

    /**
     * listName
     * @param unkown $listName
     * @return ExportFile
     */
    public function setListName($listName){
        $this->listName = $listName;
        return $this;
    }

    /**
     * listDate
     * @return unkown
     */
    public function getListDate(){
        return $this->listDate;
    }

    /**
     * listDate
     * @param unkown $listDate
     * @return ExportFile
     */
    public function setListDate($listDate){
        $this->listDate = $listDate;
        return $this;
    }

    /**
     * listMoney
     * @return unkown
     */
    public function getListMoney(){
        return $this->listMoney;
    }

    /**
     * listMoney
     * @param unkown $listMoney
     * @return ExportFile
     */
    public function setListMoney($listMoney){
        $this->listMoney = $listMoney;
        return $this;
    }


    /**
     * Main method to export file
     */
    public function export(){
    	$pathFile = './file_exported.'.$this->getType();
    	switch ($this->getType()){
    		case 'txt':{
    			$this->exportTxt($pathFile);
    			break;
    		}
    		case 'csv':{
    			$this->exportCsv($pathFile);
    			break;
    		}
    		case 'xml':{
    			$this->exportXml($pathFile);
    			break;
    		}
    	}
    	header('Content-Description: File Transfer');
    	header('Content-Type: application/octet-stream');
    	header('Content-Disposition: attachment; filename="'.basename($pathFile).'"');
    	header('Expires: 0');
    	header('Cache-Control: must-revalidate');
    	header('Pragma: public');
    	header('Content-Length: ' . filesize($pathFile));
    	readfile($pathFile);
    	exit;
    }

    /**
     * Method to export txt
     * @param string $pathFile
     */
    private function exportTxt($pathFile){
    	//main list
    	$fp = fopen($pathFile, 'w');

    	//Include header for spreadsheet
    	$headerRowCsv = array('id','name','date','money');

    	//add Header
    	foreach ($headerRowCsv as $column)
    		fwrite($fp, $column."\t");
    	fwrite($fp,"\n");

    	//add rows
    	$numRow = count($this->getListId());
    	for($i=0;$i<$numRow;$i++)
    	{
    		fwrite($fp, $this->getListId()[$i]."\t");
    		fwrite($fp, $this->getListName()[$i]."\t");
    		fwrite($fp, $this->getListDate()[$i]."\t");
    		fwrite($fp, $this->getListMoney()[$i]."\t\n");
    	}
    	fclose($fp);
    }

    /**
     * Method to export csv
     * @param string $pathFile
     */
    private function exportCsv($pathFile){
    	//main list
    	$csvList = array();

    	//Include header for spreadsheet
    	$headerRowCsv = array('id','name','date','money');

    	//add Header
    	array_push($csvList, $headerRowCsv);

    	//add rows
    	$numRow = count($this->getListId());
    	for($i=0;$i<$numRow;$i++)
    	{
    		$rowCsv = array();
    		$rowCsv[] = $this->getListId()[$i];
    		$rowCsv[] = $this->getListName()[$i];
    		$rowCsv[] = $this->getListDate()[$i];
    		$rowCsv[] = $this->getListMoney()[$i];
	    	array_push($csvList, $rowCsv);
    	}

    	$fp = fopen($pathFile, 'w');
    	foreach ($csvList as $fields) {
    		fputcsv($fp, $fields);
    	}
    	fclose($fp);
    }

    /**
     * Method to export xml
     * @param string $pathFile
     */
    private function exportXml($pathFile){

    	//creating object of SimpleXMLElement
    	$xml_offers = new SimpleXMLElement("<?xml version=\"1.0\"?><offers></offers>");

    	//function call to convert array to xml
    	$numRow = count($this->getListId());
    	for($i=0;$i<$numRow;$i++)
    	{
    		$subOffer = $xml_offers->addChild("offer");
    		$subOffer->addChild("id",htmlspecialchars($this->getListId()[$i]));
    		$subOffer->addChild("name",htmlspecialchars($this->getListName()[$i]));
    		$subOffer->addChild("date",htmlspecialchars($this->getListDate()[$i]));
    		$subOffer->addChild("money",htmlspecialchars($this->getListMoney()[$i]));
    	}
    	//saving generated xml file
    	$xml_file = $xml_offers->asXML($pathFile);
    }

}