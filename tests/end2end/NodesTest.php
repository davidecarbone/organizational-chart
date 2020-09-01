<?php

namespace OrganizationalChart\Tests\End2End;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use OrganizationalChart\Tests\ContainerAwareTest;

class NodesTest extends ContainerAwareTest
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = $this->container->get('HttpClient');
    }

    /** @test */
    public function get_nodes_children_should_respond_200_with_an_array_of_nodes()
    {
        $response = $this->client->get('nodes/5/children?language=english&search_keyword=sales&page_num=0&page_size=15');
        $responseBody = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
	    $this->assertIsArray($responseBody);
	    $this->assertArrayHasKey('nodes', $responseBody);
	    $this->assertArrayHasKey('nodeId', $responseBody['nodes'][0]);
	    $this->assertArrayHasKey('nodeName', $responseBody['nodes'][0]);
	    $this->assertArrayHasKey('childrenCount', $responseBody['nodes'][0]);
    }

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_language_is_not_provided()
	{
		$statusCode = null;
		$responseBody = [];

		try {
			$this->client->get('nodes/5/children');
		} catch (ClientException $e) {
			if ($e->hasResponse()) {
				$statusCode = $e->getResponse()->getStatusCode();
				$responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
			}
		}

		$this->assertEquals(400, $statusCode);
		$this->assertIsArray($responseBody);
		$this->assertArrayHasKey('error', $responseBody);
	}

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_language_is_invalid()
	{
		$statusCode = null;
		$responseBody = [];

		try {
			$this->client->get('nodes/5/children?language=spanish');
		} catch (ClientException $e) {
			if ($e->hasResponse()) {
				$statusCode = $e->getResponse()->getStatusCode();
				$responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
			}
		}

		$this->assertEquals(400, $statusCode);
		$this->assertIsArray($responseBody);
		$this->assertArrayHasKey('error', $responseBody);
	}

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_page_number_is_invalid()
	{
		$statusCode = null;
		$responseBody = [];

		try {
			$this->client->get('nodes/5/children?language=english&page_num=-1');
		} catch (ClientException $e) {
			if ($e->hasResponse()) {
				$statusCode = $e->getResponse()->getStatusCode();
				$responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
			}
		}

		$this->assertEquals(400, $statusCode);
		$this->assertIsArray($responseBody);
		$this->assertArrayHasKey('error', $responseBody);
	}

	/** @test */
	public function get_nodes_children_should_respond_400_with_an_error_when_page_size_is_invalid()
	{
		$statusCode = null;
		$responseBody = [];

		try {
			$this->client->get('nodes/5/children?language=english&page_num=0&page_size=1001');
		} catch (ClientException $e) {
			if ($e->hasResponse()) {
				$statusCode = $e->getResponse()->getStatusCode();
				$responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
			}
		}

		$this->assertEquals(400, $statusCode);
		$this->assertIsArray($responseBody);
		$this->assertArrayHasKey('error', $responseBody);
	}
}
