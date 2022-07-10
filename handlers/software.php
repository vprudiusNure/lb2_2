<?php
	require_once 'db.php';

	$resultsArray = null;
	$resultsParam = null;
	$dataParam = null;

	// список компьютеров с установленным ПО (название ПО выбирается из перечня)
	if (isset($_GET['getBtn'])) {
		$software_name = htmlspecialchars($_GET['softwareList']);

		$filter = ['software' => ['$in' => [$software_name]]];
		$documents = $collection->find($filter);

		$resultsArray = array();
		$resultsParam = $software_name;
		$dataParam = $software_name;

		foreach ($documents as $document) {
			$resultsArray[] = sprintf("<p><b>%s</b><br>%s: <i>Установлено</i></p>", $document['name'], $software_name);
		}
	}
	else if (isset($_GET['loadBtn'])) {
		$resultsParam = htmlspecialchars($_GET['softwareList']);
		$dataParam = htmlspecialchars($_GET['softwareList']);
	}

	include_once "view/results.phtml";
