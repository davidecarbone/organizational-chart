<?php

namespace OrganizationalChart\Node;

use mysqli;
use OrganizationalChart\Language\Language;
use OrganizationalChart\Pagination\Pagination;

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
	 * @param int        $nodeId
	 * @param Language   $language
	 * @param string     $searchKeyword
	 * @param Pagination $pagination
	 *
	 * @return Node[]
	 */
	public function findChildNodes(int $nodeId, Language $language, $searchKeyword, Pagination $pagination): array
	{
		$search = '';

		if ($searchKeyword) {
			$search = "AND name.nodeName = '$searchKeyword'";
		}

		$result = $this->connection->query(
			"SELECT child.idNode AS nodeId, nodeName,
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
			LIMIT {$pagination->pageSize()}
			OFFSET {$pagination->offset()}"
		);

		$nodes = [];
		while ($row = $result->fetch_assoc()) {
			$nodes[] = Node::fromPersistence($row);
		}

		return $nodes;
	}
}
