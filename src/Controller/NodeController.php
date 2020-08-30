<?php

namespace OrganizationalChart\Controller;

use OrganizationalChart\Node\Repository;
use Slim\Http\Request;
use Slim\Http\Response;

class NodeController
{
    /** @var Repository */
    private $repository;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

	/**
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	public function getNodes(Request $request, Response $response)
	{
		$nodes = $this->repository->findNodesById(1);

		return $response->withJson(
			empty($nodes) ? [] : $nodes->exportToArray(),
			200
		);
	}
}
