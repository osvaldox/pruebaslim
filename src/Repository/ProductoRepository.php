<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Producto;

final class ProductoRepository extends BaseRepository
{
    public function checkAndGetProducto(int $productoId): Producto
    {
        $query = 'SELECT * FROM `productos` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $productoId);
        $statement->execute();
        $producto = $statement->fetchObject(Producto::class);
        if (! $producto) {
            throw new \App\Exception\Producto('Product not found.', 404);
        }

        return $producto;
    }

    public function getProductos(): array
    {
        $query = 'SELECT * FROM `productos` ORDER BY `id`';
        $statement = $this->database->prepare($query);
        $statement->execute();

        return (array) $statement->fetchAll();
    }

    public function getQueryProductosByPage(): string
    {
        return "
            SELECT *
            FROM `productos`
            WHERE `name` LIKE CONCAT('%', :name, '%')
            AND `description` LIKE CONCAT('%', :description, '%')
            ORDER BY `id`
        ";
    }

    public function getProductosByPage(
        int $page,
        int $perPage,
        ?string $name,
        ?string $description
    ): array {
        $params = [
            'name' => is_null($name) ? '' : $name,
            'description' => is_null($description) ? '' : $description,
        ];
        $query = $this->getQueryProductosByPage();
        $statement = $this->database->prepare($query);
        $statement->bindParam('name', $params['name']);
        $statement->bindParam('description', $params['description']);
        $statement->execute();
        $total = $statement->rowCount();

        return $this->getResultsWithPagination(
            $query,
            $page,
            $perPage,
            $params,
            $total
        );
    }

    public function createProducto(Producto $producto): Producto
    {
        $query = '
            INSERT INTO `productos`
                (`name`, `description`)
            VALUES
                (:name, :description)
        ';
        $statement = $this->database->prepare($query);
        $name = $producto->getName();
        $desc = $producto->getDescription();
        $statement->bindParam(':name', $name);
        $statement->bindParam(':description', $desc);
        $statement->execute();

        return $this->checkAndGetProducto((int) $this->database->lastInsertId());
    }

    public function updateProducto(Producto $producto): Producto
    {
        $query = '
            UPDATE `productos`
            SET `name` = :name, `description` = :description
            WHERE `id` = :id
        ';
        $statement = $this->database->prepare($query);
        $id = $producto->getId();
        $name = $producto->getName();
        $desc = $producto->getDescription();
        $statement->bindParam(':id', $id);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':description', $desc);
        $statement->execute();

        return $this->checkAndGetProducto((int) $id);
    }

    public function deleteProducto(int $productoId): void
    {
        $query = 'DELETE FROM `productos` WHERE `id` = :id';
        $statement = $this->database->prepare($query);
        $statement->bindParam(':id', $productoId);
        $statement->execute();
    }
}
