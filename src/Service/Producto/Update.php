<?php

declare(strict_types=1);

namespace App\Service\Producto;

use App\Entity\Producto;

final class Update extends Base
{
    public function update(array $input, int $productoId): object
    {
        $producto = $this->getOneFromDb($productoId);
        $data = json_decode((string) json_encode($input), false);
        if (isset($data->name)) {
            $producto->updateName(self::validateProductoName($data->name));
        }
        if (isset($data->description)) {
            $producto->updateDescription($data->description);
        }
        /** @var Producto $productos */
        $productos = $this->productoRepository->updateProducto($producto);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($productos->getId(), $productos->toJson());
        }

        return $productos->toJson();
    }
}
