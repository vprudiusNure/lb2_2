<?php
	require_once 'db.php';

	$resultsArray = null;
	$resultsParam = null;
	$dataParam = null;

	// список компьютеров с заданным типом центрального процессора
	if (isset($_GET['getBtn'])) {
		$cpu_name = htmlspecialchars($_GET['cpuList']);

		$filter = ['processor' => $cpu_name];
		$documents = $collection->find($filter);

		$resultsArray = array();
		$resultsParam = $cpu_name;
		$dataParam = $cpu_name;

		foreach ($documents as $document) {
			$purchase_date = $document['purchase']->toDateTime();
			$guarantee_date = $document['guarantee']->toDateTime();

			$resultsArray[] = sprintf("<p><b>%s</b><br>Процессор: %s (%.1f ГГц)<br>Материнская плата: %s<br>Внутренний накопитель: %d ГБ<br>Оперативная память: %d ГБ<br>Дата покупки: %s<br>Дата истечения гарантийного срока: %s (%d года)</p>", $document['name'], $document['processor'], $document['frequency'], $document['motherboard'], $document['hdd_capacity'], $document['ram_capacity'], $purchase_date->format('d.m.Y'), $guarantee_date->format('d.m.Y'), $guarantee_date->format('Y') - $purchase_date->format('Y'));
		}
	}
	else if (isset($_GET['loadBtn'])) {
		$resultsParam = htmlspecialchars($_GET['cpuList']);
		$dataParam = htmlspecialchars($_GET['cpuList']);
	}

	include_once "view/results.phtml";
