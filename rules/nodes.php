<?php

use OrganizationalChart\Node\Repository;

$container['Node\Repository'] = function($container) {

	/** @var mysqli $connection */
	$connection = $this->get('Connection');

	return new Repository($connection);
};
