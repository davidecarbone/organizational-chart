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
		$nodeId = (int) $request->getAttribute('nodeId');
		$language = $request->getQueryParam('language');
		$searchKeyword = $request->getQueryParam('search_keyword');
		$pageNumber = $request->getQueryParam('page_num') ?: 0;
		$pageSize = $request->getQueryParam('page_size') ?: 100;

		$nodes = $this->repository->findNodeByIdAndLanguage($nodeId, $language, $searchKeyword, $pageNumber, $pageSize);

		return $response->withJson(
			empty($nodes) ? [] : ['nodes' => $nodes],
			200
		);
	}
}
