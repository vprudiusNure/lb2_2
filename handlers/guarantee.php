<?php
	require_once 'db.php';

	$resultsArray = null;
	$resultsParam = null;
	$dataParam = null;

	// список компьютеров с истекшим гарантийным сроком
	if (isset($_GET['getBtn'])) {
		$param = htmlspecialchars($_GET['guaranteeDate']);

		$datetimeUTC = strtotime($param . ' UTC') * 1000;
		$MongoDBDate = new MongoDB\BSON\UTCDateTime($datetimeUTC);

		$filter = ['guarantee' => ['$lt' => $MongoDBDate]];
		$options = ['sort' => ['guarantee' => 1]];
		$documents = $collection->find($filter, $options);

		$resultsArray = array();
		$resultsParam = date('d.m.Y', strtotime($param));
		$dataParam = date('Y-m-d', strtotime($param));

		foreach ($documents as $document) {
			$purchase_date = $document['purchase']->toDateTime();
			$guarantee_date = $document['guarantee']->toDateTime();

			$resultsArray[] = sprintf("<p><b>%s</b><br>Процессор: %s (%.1f ГГц)<br>Материнская плата: %s<br>Внутренний накопитель: %d ГБ<br>Оперативная память: %d ГБ<br>Дата покупки: %s<br>Дата истечения гарантийного срока: <span style=\"color: red;\">%s (%d года) <b>Срок гарантии истёк!</b><span></p>", $document['name'], $document['processor'], $document['frequency'], $document['motherboard'], $document['hdd_capacity'], $document['ram_capacity'], $purchase_date->format('d.m.Y'), $guarantee_date->format('d.m.Y'), $guarantee_date->format('Y') - $purchase_date->format('Y'));
		}
	}
	else if (isset($_GET['loadBtn'])) {
		$resultsParam = date('d.m.Y', strtotime(htmlspecialchars($_GET['guaranteeDate'])));
		$dataParam = date('Y-m-d', strtotime(htmlspecialchars($_GET['guaranteeDate'])));
	}

	include_once "view/results.phtml";
