<?php

class Order_Model extends CW_Model
{
    private $providerId;
    private $contributorId;
    private $observations;
    private $finished;
    private $createdAt;
    private $updatedAt;

    public function fetch()
    {
        $sql = <<<SQL
            SELECT *
            FROM orders o;
        SQL;
        $query = $this->db->query($sql);
        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function ajaxFetch($observations, $limit, $offset)
    {
        $sql = <<<SQL
            SELECT *
            FROM orders o
            WHERE o.observations LIKE ?
            LIMIT ?
            OFFSET ?;
        SQL;
        $query = $this->db->query($sql, [
            '%' . $observations . '%',
            $limit,
            $offset
        ]);
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
            FROM orders o
            WHERE o.id = ?;
        SQL;
        $query = $this->db->query($sql, [$id]);

        $row = $query->row();

        return $row;
    }

    public function fetchFinished($limit, $offset)
    {
        $sql = <<<SQL
            SELECT *
            FROM orders o
            WHERE o.finished = 1
            LIMIT ?
            OFFSET ?;
        SQL;
        $query = $this->db->query($sql, [
            $limit,
            $offset,
        ]);

        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toAPIResponse($row));
        }

        return $formatedResults;
    }

    public function insert()
    {
        $sql = <<<SQL
            INSERT INTO orders (
                providerId,
                contributorId,
                observations,
                finished,
                createdAt,
                updatedAt
            )
            VALUES (?, ?, ?, ?, ?, ?);
        SQL;
        $this->db->query($sql, [
            $this->providerId,
            $this->contributorId,
            $this->observations,
            $this->finished,
            $this->createdAt,
            $this->updatedAt
        ]);
        return intval($this->db->insert_id());
    }

    public function update($id)
    {
        $sql = <<<SQL
            UPDATE orders o SET
                providerId = ?,
                observations = ?,
                finished = ?,
                updatedAt = ?
            WHERE o.id = ?;
        SQL;
        $query = $this->db->query($sql, [
            $this->providerId,
            $this->observations,
            $this->finished,
            $this->updatedAt,
            $id
        ]);
        return $query;
    }

    public function delete($id)
    {
        $sql = <<<SQL
            DELETE FROM orders
            WHERE id = ?;
        SQL;
        $query = $this->db->query($sql, [$id]);
        return $query;
    }

    public function prepare($operation, $data)
    {
        $this->providerId = $data->providerId;
        $this->observations = trim($data->observations);
        $this->finished = $data->finished ? 1 : 0;
        $now = new DateTime();
        if ($operation === 'insert') {
            $this->contributorId = $data->contributorId;
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
        $response->providerId = $data->providerId;
        $response->contributorId = $data->contributorId;
        $response->observations = $data->observations;
        $response->finished = $data->finished;
        $response->createdAt = $data->createdAt;
        $response->updatedAt = $data->updatedAt;

        return $response;
    }

    public function toAPIResponse($data)
    {
        $response = new stdClass();
        $response->id = $data->id;
        $response->providerId = $data->providerId;
        $response->contributorId = $data->contributorId;
        $response->observations = $data->observations;
        $response->createdAt = $data->createdAt;
        $response->updatedAt = $data->updatedAt;

        return $response;
    }

    public function cleanModel()
    {
        $this->providerId = NULL;
        $this->contributorId = NULL;
        $this->observations = NULL;
        $this->finished = NULL;
        $this->createdAt = NULL;
        $this->updatedAt = NULL;
    }
}
