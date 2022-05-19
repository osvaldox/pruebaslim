<?php

declare(strict_types=1);

namespace App\Controller\Producto;

use Slim\Http\Request;
use Slim\Http\Response;

final class Update extends Base
{
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): Response {
        $input = (array) $request->getParsedBody();
        $producto = $this->getServiceUpdateProducto()->update($input, (int) $args['id']);

        return $this->jsonResponse($response, 'success', $producto, 200);
    }
}
