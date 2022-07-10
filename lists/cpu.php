<?php
	require_once 'db.php';

	$cursor = $collection->find();

	$cpus = array();
	foreach ($cursor as $document) {
		$cpus[] = $document['processor'];
	};

	$cpus = array_unique($cpus);
	asort($cpus, SORT_STRING);

	foreach ($cpus as $cpu) {
		printf("<option value=\"%s\">%s</option>", $cpu, $cpu);
	}
