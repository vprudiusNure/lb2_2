<?php
	require_once 'db.php';

	$cursor = $collection->find();

	$softwares = array();
	foreach ($cursor as $document) {
		$softwares = array_merge($softwares, $document['software']->getArrayCopy());
	};

	$softwares = array_unique($softwares);
	asort($softwares, SORT_STRING);

	foreach ($softwares as $software) {
		printf("<option value=\"%s\">%s</option>", $software, $software);
	}
