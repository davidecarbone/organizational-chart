<?php

namespace OrganizationalChart\Node;

use mysqli;

class Repository
{
	/** @var mysqli */
	private $connection;

	/**
	 * @param mysqli $connection
	 */
	public function __construct(mysqli $connection)
    {
	    $this->connection = $connection;
    }

	/**
	 * @param int $nodeId
	 *
	 * @return Node|null
	 */
	public function findNodesById(int $nodeId): ?Node
	{
		$results = $this->connection->query('SELECT * FROM node_tree');
		var_dump($results);die;

		return Node::fromPersistence($result);
	}
}
