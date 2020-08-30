<?php

use OrganizationalChart\Configuration\Configuration;

$container['Configuration'] = function() {
	$configuration = include_once(__DIR__ . '/../config/config.php');

	return new Configuration($configuration);
};

$container['Connection'] = function($container) {

	/** @var Configuration */
	$configuration = $container['Configuration'];

	$dbHost = $configuration->get('DB_HOST');
	$dbUsername = $configuration->get('DB_USERNAME');
	$dbPassword = $configuration->get('DB_PASSWORD');
	$dbName = $configuration->get('DB_NAME');

	if (!$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName)) {
		throw new \Exception("Could not connect to the database.");
	}

	return $connection;
};
