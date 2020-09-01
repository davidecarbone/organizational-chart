<?php

namespace OrganizationalChart\Node;

final class Node implements \JsonSerializable
{
	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/** @var int */
	private $childrenCount;

	private function __construct()
	{
	}

	/**
	 * @param array $data
	 *
	 * @return Node
	 */
	public static function fromPersistence(array $data): Node
	{
		$node = new self;
		$node->id = $data['nodeId'];
		$node->name = $data['nodeName'];
		$node->childrenCount = $data['childrenCount'];

		return $node;
	}

	public function jsonSerialize()
	{
		return [
			'nodeId' => $this->id,
			'nodeName' => $this->name,
			'childrenCount' => $this->childrenCount
		];
	}
}
