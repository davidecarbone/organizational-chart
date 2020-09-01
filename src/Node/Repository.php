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
	 * @param string $searchKeyword
	 * @param int    $pageNumber
	 * @param int    $pageSize
	 *
	 * @return array|null
	 */
	public function findChildNodes(int $nodeId, string $language, $searchKeyword, $pageNumber, $pageSize): ?array
	{
		$offset = $pageNumber * $pageSize;

		if ($searchKeyword) {
			$search = "AND name.nodeName = '$searchKeyword'";
		}

		$result = $this->connection->query(
			"SELECT child.idNode, nodeName AS name,
			   (
			     SELECT COUNT(child2.idNode)
				 FROM node_tree AS child2, node_tree AS parent
				 WHERE
				   parent.idNode = child.idNode
				   AND child2.level = parent.level+1
				   AND child2.iLeft > parent.iLeft
				   AND child2.iRight < parent.iRight
			   ) AS childrenCount
			FROM node_tree AS child, node_tree AS parent, node_tree_names name 
			WHERE
			  parent.idNode = '$nodeId'
			  AND child.level = parent.level+1
			  AND child.iLeft > parent.iLeft
			  AND child.iRight < parent.iRight
			  AND child.idNode = name.idNode 
			  AND language = '$language'
			  $search
			ORDER BY child.idNode ASC 
			LIMIT $pageSize
			OFFSET $offset"
		);

		$nodes = [];
		while ($row = $result->fetch_assoc()) {
			$nodes[] = $row;
		}

		return $nodes;
	}
}
