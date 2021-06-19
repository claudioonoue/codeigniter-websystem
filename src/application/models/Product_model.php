<?php

class Product_Model extends CW_Model
{
    private $name;
    private $description;
    private $active;
    private $createdAt;
    private $updatedAt;

    public function fetch()
    {
        $sql = <<<SQL
            SELECT *
            FROM products p;
        SQL;
        $query = $this->db->query($sql);
        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function fetchById($id)
    {
        $sql = <<<SQL
            SELECT *
            FROM products p
            WHERE p.id = ?;
        SQL;
        $query = $this->db->query($sql, [$id]);

        $row = $query->row();

        return $row;
    }

    public function insert()
    {
        $sql = <<<SQL
            INSERT INTO products (
                name,
                description,
                active,
                createdAt,
                updatedAt
            )
            VALUES (?, ?, ?, ?, ?);
        SQL;
        $query = $this->db->query($sql, [
            $this->name,
            $this->description,
            $this->active,
            $this->createdAt,
            $this->updatedAt
        ]);
        return $query;
    }

    public function update($id)
    {
        $sql = <<<SQL
            UPDATE products p SET
                name = ?,
                description = ?,
                active = ?,
                updatedAt = ?
            WHERE p.id = ?;
        SQL;
        $query = $this->db->query($sql, [
            $this->name,
            $this->description,
            $this->active,
            $this->updatedAt,
            $id
        ]);
        return $query;
    }

    public function prepare($operation, $data)
    {
        $this->name = trim($data->name);
        $this->description = trim($data->description);
        $this->active = $data->active ? 1 : 0;
        $now = new DateTime();
        if ($operation === 'insert') {
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
        $response->name = $data->name;
        $response->description = $data->description;
        $response->active = $data->active;
        $response->createdAt = $data->createdAt;
        $response->updatedAt = $data->updatedAt;

        return $response;
    }

    public function cleanModel()
    {
        $this->name = NULL;
        $this->description = NULL;
        $this->active = NULL;
        $this->createdAt = NULL;
        $this->updatedAt = NULL;
    }
}
