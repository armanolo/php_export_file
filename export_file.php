<?php
require_once 'DO_ExportFile.php';

$typeExport = $_POST['export'];
$listId = $_POST['id'];
$listName = $_POST['name'];
$listDate = $_POST['date'];
$listMoney = $_POST['money'];

//Create class to export file
$exporFile = new ExportFile();
$exporFile->setType($typeExport);
$exporFile->setListId($listId);
$exporFile->setListName($listName);
$exporFile->setListDate($listDate);
$exporFile->setListMoney($listMoney);
//Method get export file
$exporFile->export();