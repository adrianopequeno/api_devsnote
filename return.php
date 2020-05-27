<?php

	header("Access-Control-Allow-Origin: *");
	header("Access_Control-allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
	header("Content-Type: application/json");
	echo json_encode($array);
	exit;