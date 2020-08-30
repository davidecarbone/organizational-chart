<?php

use OrganizationalChart\Controller\NodeController;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/nodes/{nodeId}', function (Request $request, Response $response) {

	$repository = $this->get('Node\Repository');
	$controller = new NodeController($repository);

	return $controller->getNodes($request, $response);
});
