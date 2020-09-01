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
		$language = $request->getQueryParam('language') ?? '';
		$searchKeyword = $request->getQueryParam('search_keyword') ?? '';
		$pageNumber = $request->getQueryParam('page_num') ?? 0;
		$pageSize = $request->getQueryParam('page_size') ?? 100;

		try {
			$this->assertLanguageIsValid($language);
			$this->assertPageNumberIsValid($pageNumber);
			$this->assertPageSizeIsValid($pageSize);
		} catch (\InvalidArgumentException $e) {
			return $response->withJson([
				'error' => $e->getMessage()
			], 400);
		}

		$nodes = $this->repository->findChildNodes($nodeId, $language, $searchKeyword, $pageNumber, $pageSize);

		return $response->withJson(
			empty($nodes) ? [] : ['nodes' => $nodes],
			200
		);
	}

	/**
	 * @param string $language
	 */
	private function assertLanguageIsValid(string $language)
	{
		if (empty($language) || !in_array($language, ['english', 'italian'])) {
			throw new \InvalidArgumentException("language parameter is required to be either 'english' or 'italian'");
		}
	}

	/**
	 * @param $pageNumber
	 */
	private function assertPageNumberIsValid($pageNumber)
	{
		if (!preg_match('/^[0-9]+$/', $pageNumber)) {
			throw new \InvalidArgumentException("page_num must be an integer >= 0");
		}
	}

	/**
	 * @param $pageSize
	 */
	private function assertPageSizeIsValid($pageSize)
	{
		if (!preg_match('/^(0|[1-9][0-9]{0,2}|1000)$/', $pageSize)) {
			throw new \InvalidArgumentException("page_size must be an integer between 0 and 1000");
		}
	}
}
