<?php

namespace OrganizationalChart\Tests\Integration;

use OrganizationalChart\Language\Language;
use OrganizationalChart\Node\Node;
use OrganizationalChart\Node\Repository;
use OrganizationalChart\Pagination\Pagination;
use OrganizationalChart\Tests\ContainerAwareTest;

class RepositoryTest extends ContainerAwareTest
{
    /** @var Repository */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = $this->container->get('Node\Repository');
    }

	/** @test */
	public function can_find_child_nodes()
	{
		$nodes = $this->repository->findChildNodes(5, new Language('english'), '', new Pagination(0, 100));

		$this->assertIsArray($nodes);
		$this->assertInstanceOf(Node::class, $nodes[0]);
	}
}
