<?php
	function isConnectionSet($client, $db, $collection) {
		if (isset($client) && isset($db) && isset($collection)) {
			print("<p>MongoDB connection established. Database and collection selected</p><hr>\n");
		}
	}

	$host = 'localhost';
	$port = '27017';
	$dbname = 'itech';
	$cname = 'computers';

	try {
		$client = new MongoDB\Client("mongodb://$host:$port");
		$db = $client->selectDatabase($dbname);
		$collection = $db->selectCollection($cname);
	}
	catch (\Exception $e) {
		print "<b>Error!</b><br>MongoDB connection error<hr>";
		die();
	}
