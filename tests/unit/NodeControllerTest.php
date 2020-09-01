<?php

namespace OrganizationalChart\Tests\Unit;

use OrganizationalChart\Node\Node;
use OrganizationalChart\Node\Repository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use OrganizationalChart\Controller\NodeController;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class ProductControllerTest extends TestCase
{
    /** @var NodeController */
    private $productController;

    /** @var Repository | MockObject */
    private $repositoryMock;

    public function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->createMock(Repository::class);
        $this->productController = new NodeController($this->repositoryMock);
    }

    /** @test */
    public function get_nodes_children_should_respond_200_with_an_array_of_nodes()
    {
        $response = new Response();
        $nodeId = 5;
	    $nodes = [
            Node::fromPersistence([
		        "nodeId" => $nodeId,
		        "nodeName" => 'test',
		        "childrenCount" => 3
	        ])
        ];

        $this->repositoryMock
            ->expects($this->once())
            ->method('findChildNodes')
            ->willReturn($nodes);

        $environment = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => "/nodes/$nodeId/children",
            'QUERY_STRING' => ''
        ]);
        $request = Request::createFromEnvironment($environment);
	    $request = $request->withAttribute('nodeId', $nodeId);
	    $request = $request->withQueryParams([
	    	'language' => 'english',
		    'page_num' => 1,
		    'page_size' => 15,
		    'search_keyword' => 'test'
	    ]);

        $response = $this->productController->getNodes($request, $response);
        $responseContent = $this->getResponseContent($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsArray($responseContent);
        $this->assertArrayHasKey('nodes', $responseContent);
        $this->assertArrayHasKey('nodeId', $responseContent['nodes'][0]);
        $this->assertArrayHasKey('nodeName', $responseContent['nodes'][0]);
        $this->assertArrayHasKey('childrenCount', $responseContent['nodes'][0]);
    }

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_language_is_not_provided()
	{
		$response = new Response();
		$nodeId = 5;

		$this->repositoryMock
			->expects($this->never())
			->method('findChildNodes');

		$environment = Environment::mock([
			'REQUEST_METHOD' => 'GET',
			'REQUEST_URI' => "/nodes/$nodeId/children",
			'QUERY_STRING' => ''
		]);
		$request = Request::createFromEnvironment($environment);
		$request = $request->withAttribute('nodeId', $nodeId);

		$response = $this->productController->getNodes($request, $response);
		$responseContent = $this->getResponseContent($response);

		$this->assertEquals(400, $response->getStatusCode());
		$this->assertIsArray($responseContent);
		$this->assertArrayHasKey('error', $responseContent);
	}

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_language_is_invalid()
	{
		$response = new Response();
		$nodeId = 5;

		$this->repositoryMock
			->expects($this->never())
			->method('findChildNodes');

		$environment = Environment::mock([
			'REQUEST_METHOD' => 'GET',
			'REQUEST_URI' => "/nodes/$nodeId/children",
			'QUERY_STRING' => ''
		]);
		$request = Request::createFromEnvironment($environment);
		$request = $request->withAttribute('nodeId', $nodeId);
		$request = $request->withQueryParams(['language' => 'french']);

		$response = $this->productController->getNodes($request, $response);
		$responseContent = $this->getResponseContent($response);

		$this->assertEquals(400, $response->getStatusCode());
		$this->assertIsArray($responseContent);
		$this->assertArrayHasKey('error', $responseContent);
	}

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_page_number_is_invalid()
	{
		$response = new Response();
		$nodeId = 5;

		$this->repositoryMock
			->expects($this->never())
			->method('findChildNodes');

		$environment = Environment::mock([
			'REQUEST_METHOD' => 'GET',
			'REQUEST_URI' => "/nodes/$nodeId/children",
			'QUERY_STRING' => ''
		]);
		$request = Request::createFromEnvironment($environment);
		$request = $request->withAttribute('nodeId', $nodeId);
		$request = $request->withQueryParams(['language' => 'english']);
		$request = $request->withQueryParams(['page_num' => 'bad']);

		$response = $this->productController->getNodes($request, $response);
		$responseContent = $this->getResponseContent($response);

		$this->assertEquals(400, $response->getStatusCode());
		$this->assertIsArray($responseContent);
		$this->assertArrayHasKey('error', $responseContent);
	}

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_page_size_is_invalid()
	{
		$response = new Response();
		$nodeId = 5;

		$this->repositoryMock
			->expects($this->never())
			->method('findChildNodes');

		$environment = Environment::mock([
			'REQUEST_METHOD' => 'GET',
			'REQUEST_URI' => "/nodes/$nodeId/children",
			'QUERY_STRING' => ''
		]);
		$request = Request::createFromEnvironment($environment);
		$request = $request->withAttribute('nodeId', $nodeId);
		$request = $request->withQueryParams(['language' => 'english']);
		$request = $request->withQueryParams(['page_size' => 'bad']);

		$response = $this->productController->getNodes($request, $response);
		$responseContent = $this->getResponseContent($response);

		$this->assertEquals(400, $response->getStatusCode());
		$this->assertIsArray($responseContent);
		$this->assertArrayHasKey('error', $responseContent);
	}

    /**
     * @param Response $response
     *
     * @return array
     */
    private function getResponseContent(Response $response): array
    {
        $body = $response->getBody();
        $body->rewind();

        return json_decode($body->getContents(), true);
    }
}
