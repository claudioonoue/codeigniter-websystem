<?php

class Order_Product_Model extends CW_Model
{
    private $orderId;
    private $productId;
    private $quantity;
    private $unitPrice;
    private $createdAt;
    private $updatedAt;

    public function fetchByOrderId($orderId)
    {
        $sql = <<<SQL
            SELECT *
            FROM orders_products op
            WHERE op.orderId = ?;
        SQL;
        $query = $this->db->query($sql, [$orderId]);

        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function fetchAPIByOrderId($orderId)
    {
        $sql = <<<SQL
            SELECT 
                op.productId,
                p.name,
                p.description,
                op.quantity,
                op.unitPrice
            FROM orders_products op
            INNER JOIN products p
            ON p.id = op.productId
            WHERE op.orderId = ?;
        SQL;
        $query = $this->db->query($sql, [$orderId]);

        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toAPIResponse($row));
        }

        return $formatedResults;
    }

    public function insert()
    {
        $sql = <<<SQL
            INSERT INTO orders_products (
                orderId,
                productId,
                quantity,
                unitPrice,
                createdAt,
                updatedAt
            )
            VALUES (?, ?, ?, ?, ?, ?);
        SQL;
        $query = $this->db->query($sql, [
            $this->orderId,
            $this->productId,
            $this->quantity,
            $this->unitPrice,
            $this->createdAt,
            $this->updatedAt
        ]);
        return $query;
    }

    public function deleteByOrderId($orderId)
    {
        $sql = <<<SQL
            DELETE FROM orders_products
            WHERE orderId = ?;
        SQL;
        $query = $this->db->query($sql, [$orderId]);
        return $query;
    }

    public function prepare($operation, $data)
    {
        $this->quantity = intval($data->quantity);
        $this->unitPrice = intval($data->unitPrice);
        $now = new DateTime();
        if ($operation === 'insert') {
            $this->orderId = $data->orderId;
            $this->productId = $data->productId;
            $this->createdAt = $now->format(DATE_ATOM);
            $this->updatedAt = $now->format(DATE_ATOM);
        } elseif ($operation === 'update') {
            $this->updatedAt = $now->format(DATE_ATOM);
        }
    }

    public function toResponse($data)
    {
        $response = new stdClass();
        $response->id = $data->id;
        $response->orderId = $data->orderId;
        $response->productId = $data->productId;
        $response->quantity = $data->quantity;
        $response->unitPrice = $data->unitPrice;
        $response->createdAt = $data->createdAt;
        $response->updatedAt = $data->updatedAt;

        return $response;
    }

    public function toAPIResponse($data)
    {
        $response = new stdClass();
        $response->productId = $data->productId;
        $response->name = $data->name;
        $response->description = $data->description;
        $response->quantity = $data->quantity;
        $response->unitPrice = $data->unitPrice;

        return $response;
    }

    public function cleanModel()
    {
        $this->orderId = NULL;
        $this->productId = NULL;
        $this->quantity = NULL;
        $this->unitPrice = NULL;
        $this->createdAt = NULL;
        $this->updatedAt = NULL;
    }
}
