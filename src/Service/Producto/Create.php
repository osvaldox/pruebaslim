<?php

declare(strict_types=1);

namespace App\Service\Producto;

use App\Entity\Producto;

final class Create extends Base
{
    public function create(array $input): object
    {
        $data = json_decode((string) json_encode($input), false);
        if (! isset($data->name)) {
            throw new \App\Exception\Producto('Invalid data: name is required.', 400);
        }
        $myproducto = new Producto();
        $myproducto->updateName(self::validateProductoName($data->name));
        $desc = $data->description ?? null;
        $myproducto->updateDescription($desc);
        /** @var Producto $producto */
        $producto = $this->productoRepository->createProducto($myproducto);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($producto->getId(), $producto->toJson());
        }

        return $producto->toJson();
    }
}
