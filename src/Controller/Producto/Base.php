<?php

declare(strict_types=1);

namespace App\Controller\Producto;

use App\Controller\BaseController;
use App\Service\Producto\Create;
use App\Service\Producto\Delete;
use App\Service\Producto\Find;
use App\Service\Producto\Update;

abstract class Base extends BaseController
{
    protected function getServiceFindProducto(): Find
    {
        return $this->container->get('find_producto_service');
    }

    protected function getServiceCreateProducto(): Create
    {
        return $this->container->get('create_producto_service');
    }

    protected function getServiceUpdateProducto(): Update
    {
        return $this->container->get('update_producto_service');
    }

    protected function getServiceDeleteProducto(): Delete
    {
        return $this->container->get('delete_producto_service');
    }
}
