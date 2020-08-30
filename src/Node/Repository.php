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
	 * @param int    $nodeId
	 * @param string $language
	 *
	 * @return array|null
	 */
	public function findNodeByIdAndLanguage(int $nodeId, string $language): ?array
	{
		$result = $this->connection->query(
			"SELECT
			   node.idNode,
			   name.nodeName,
			   (
			     SELECT COUNT(child.idNode)
				 FROM node_tree AS child, node_tree AS parent
				 WHERE
				   parent.idNode = '$nodeId'
				   AND child.level = parent.level+1
				   AND child.iLeft > parent.iLeft
				   AND child.iRight < parent.iRight
			   ) AS childrenCount
			 FROM node_tree AS node
			 INNER JOIN node_tree_names AS name ON node.idNode = name.idNode
			 WHERE node.idNode = '$nodeId'
			   AND language = '$language'"
		);

		if (!$row = $result->fetch_assoc()) {
			return null;
		}

		return $row;
	}
}
