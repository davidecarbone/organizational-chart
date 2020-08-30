<?php

use OrganizationalChart\Node\Repository;

$container['Node\Repository'] = function($container) {

	/** @var mysqli $connection */
	$connection = $container->get('Connection');

	return new Repository($connection);
};
