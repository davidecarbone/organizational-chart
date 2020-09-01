<?php

namespace OrganizationalChart\Tests\Unit;

use OrganizationalChart\Node\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
	/** @test */
	public function can_be_built_from_array_and_exported_to_array()
	{
		$data = [
			'nodeId' => 1,
			'nodeName' => 'test',
			'childrenCount' => 4
		];

		$node = Node::fromPersistence($data);
		$nodeData = $node->exportToArray();

		$this->assertEquals(1, $nodeData['nodeId']);
		$this->assertEquals('test', $nodeData['nodeName']);
		$this->assertEquals(4, $nodeData['childrenCount']);
	}
}
