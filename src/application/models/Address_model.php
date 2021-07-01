<?php

class Address_Model extends CW_Model
{
    private $userId;
    private $addressOrdenation;
    private $zipCode;
    private $address;
    private $number;
    private $complement;
    private $neighborhood;
    private $city;
    private $state;
    private $country;
    private $active;
    private $createdAt;
    private $updatedAt;

    public function fetchByUserId($userId, $api = false)
    {
        $sql = <<<SQL
            SELECT *
            FROM addresses a
            WHERE a.userId = ?
            ORDER BY a.addressOrdenation ASC;
        SQL;
        $query = $this->db->query($sql, [$userId]);
        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, !$api ? $this->toResponse($row) : $this->toAPIResponse($row));
        }

        return $formatedResults;
    }

    public function insert()
    {
        $sql = <<<SQL
            INSERT INTO addresses (
                userId,
                addressOrdenation,
                zipCode,
                address,
                number,
                complement,
                neighborhood,
                city,
                state,
                country,
                active,
                createdAt,
                updatedAt
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        SQL;
        $query = $this->db->query($sql, [
            $this->userId,
            $this->addressOrdenation,
            $this->zipCode,
            $this->address,
            $this->number,
            $this->complement,
            $this->neighborhood,
            $this->city,
            $this->state,
            $this->country,
            $this->active,
            $this->createdAt,
            $this->updatedAt
        ]);
        return $query;
    }

    public function update($userId, $addressOrdenation)
    {
        $sql = <<<SQL
            UPDATE addresses a SET
                zipCode = ?,
                address = ?,
                number = ?,
                complement = ?,
                neighborhood = ?,
                city = ?,
                state = ?,
                country = ?,
                active = ?,
                updatedAt = ?
            WHERE a.userId = ? 
            AND a.addressOrdenation = ?;
        SQL;
        $query = $this->db->query($sql, [
            $this->zipCode,
            $this->address,
            $this->number,
            $this->complement,
            $this->neighborhood,
            $this->city,
            $this->state,
            $this->country,
            $this->active,
            $this->updatedAt,
            $userId,
            $addressOrdenation
        ]);
        return $query;
    }

    public function delete($userId)
    {
        $sql = <<<SQL
            DELETE FROM addresses
            WHERE userId = ?;
        SQL;
        $query = $this->db->query($sql, [$userId]);
        return $query;
    }

    public function prepare($operation, $data)
    {
        $this->zipCode = trim(str_replace(['.', '-'], '', $data->zipCode));
        $this->address = trim($data->address);
        $this->number = trim($data->number);
        $this->complement = trim($data->complement);
        $this->neighborhood = trim($data->neighborhood);
        $this->city = trim($data->city);
        $this->state = trim($data->state);
        $this->country = trim($data->country);
        $this->active = $data->active ? 1 : 0;
        $now = new DateTime();
        if ($operation === 'insert') {
            $this->userId = $data->userId;
            $this->addressOrdenation = $data->addressOrdenation;
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
        $response->userId = $data->userId;
        $response->addressOrdenation = $data->addressOrdenation;
        $response->zipCode = $data->zipCode;
        $response->address = $data->address;
        $response->number = $data->number;
        $response->complement = $data->complement;
        $response->neighborhood = $data->neighborhood;
        $response->city = $data->city;
        $response->state = $data->state;
        $response->country = $data->country;
        $response->active = $data->active;
        $response->createdAt = $data->createdAt;
        $response->updatedAt = $data->updatedAt;

        return $response;
    }

    public function toAPIResponse($data)
    {
        $response = new stdClass();
        $response->id = $data->id;
        $response->zipCode = $data->zipCode;
        $response->address = $data->address;
        $response->number = $data->number;
        $response->complement = $data->complement;
        $response->neighborhood = $data->neighborhood;
        $response->city = $data->city;
        $response->state = $data->state;
        $response->country = $data->country;

        return $response;
    }

    public function cleanModel()
    {
        $this->userId = NULL;
        $this->addressOrdenation = NULL;
        $this->zipCode = NULL;
        $this->address = NULL;
        $this->number = NULL;
        $this->complement = NULL;
        $this->neighborhood = NULL;
        $this->city = NULL;
        $this->state = NULL;
        $this->country = NULL;
        $this->active = NULL;
        $this->createdAt = NULL;
        $this->updatedAt = NULL;
    }
}
