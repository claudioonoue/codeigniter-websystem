<?php

class User_Model extends CW_Model
{
    private $email;
    private $password;
    private $fullName;
    private $phone;
    private $isAdmin;
    private $hasSystemAccess;
    private $isProvider;
    private $active;
    private $createdAt;
    private $updatedAt;

    public function fetch()
    {
        $sql = <<<SQL
            SELECT u.*, 
            (
                SELECT COUNT(a.id)
                FROM addresses a
                WHERE a.userId = u.id
            ) AS `totalAddresses`
            FROM users u;
        SQL;
        $query = $this->db->query($sql);
        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function fetchWithoutLoggedUser($id, $fullName, $email, $limit, $offset)
    {
        $sql = <<<SQL
            SELECT u.*, 
            (
                SELECT COUNT(a.id)
                FROM addresses a
                WHERE a.userId = u.id
            ) AS `totalAddresses`
            FROM users u
            WHERE u.id != ?
            AND u.fullName LIKE ?
            AND u.email LIKE ?
            LIMIT ?
            OFFSET ?;
        SQL;
        $query = $this->db->query($sql, [
            $id,
            '%' . $fullName . '%',
            '%' . $email . '%',
            $limit,
            $offset
        ]);
        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function fetchById($id, $api = false)
    {
        $sql = <<<SQL
            SELECT u.*, 
            (
                SELECT COUNT(a.id)
                FROM addresses a
                WHERE a.userId = u.id
            ) AS `totalAddresses`
            FROM users u
            WHERE u.id = ?;
        SQL;
        $query = $this->db->query($sql, [$id]);

        $row = $query->row();

        if ($api) {
            return $this->toAPIResponse($row);
        }

        return $row;
    }

    public function fetchByEmail($email)
    {
        $sql = <<<SQL
            SELECT * 
            FROM users u
            WHERE u.email = ?;
        SQL;
        $query = $this->db->query($sql, [$email]);

        $row = $query->row();

        return $row;
    }

    public function fetchProviders()
    {
        $sql = <<<SQL
            SELECT * 
            FROM users u
            WHERE u.isProvider = 1;
        SQL;
        $query = $this->db->query($sql);

        $formatedResults = [];

        foreach ($query->result() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function insert()
    {
        $sql = <<<SQL
            INSERT INTO users (
                email,
                password,
                fullName,
                phone,
                isAdmin,
                hasSystemAccess,
                isProvider,
                active,
                createdAt,
                updatedAt
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
        SQL;
        $query = $this->db->query($sql, [
            $this->email,
            $this->password,
            $this->fullName,
            $this->phone,
            $this->isAdmin,
            $this->hasSystemAccess,
            $this->isProvider,
            $this->active,
            $this->createdAt,
            $this->updatedAt
        ]);
        return $query;
    }

    public function update($id)
    {
        $sql = <<<SQL
            UPDATE users u SET
                password = ?,
                fullName = ?,
                phone = ?,
                isAdmin = ?,
                hasSystemAccess = ?,
                isProvider = ?,
                active = ?,
                updatedAt = ?
            WHERE u.id = ?;
        SQL;
        $query = $this->db->query($sql, [
            $this->password,
            $this->fullName,
            $this->phone,
            $this->isAdmin,
            $this->hasSystemAccess,
            $this->isProvider,
            $this->active,
            $this->updatedAt,
            $id
        ]);
        return $query;
    }

    public function prepare($operation, $data)
    {
        $this->fullName = trim($data->fullName);
        $this->phone = trim($data->phone);
        $this->isAdmin = $data->isAdmin ? 1 : 0;
        $this->hasSystemAccess = $data->hasSystemAccess ? 1 : 0;
        $this->isProvider = $data->isProvider ? 1 : 0;
        $this->active = $data->active ? 1 : 0;
        $now = new DateTime();
        if ($operation === 'insert') {
            $this->email = trim($data->email);
            $this->password = password_hash($data->password, PASSWORD_BCRYPT);
            $this->createdAt = $now->format(DATE_ATOM);
            $this->updatedAt = $now->format(DATE_ATOM);
        } elseif ($operation === 'update') {
            $this->password = isset($data->newPassword) ? password_hash($data->newPassword, PASSWORD_BCRYPT) : $data->password;
            $this->updatedAt = $now->format(DATE_ATOM);
        }
    }

    public function toResponse($data)
    {
        $response = new stdClass();
        $response->id = $data->id;
        $response->email = $data->email;
        $response->fullName = $data->fullName;
        $response->phone = $data->phone;
        $response->isAdmin = $data->isAdmin;
        $response->hasSystemAccess = $data->hasSystemAccess;
        $response->isProvider = $data->isProvider;
        $response->active = $data->active;
        $response->createdAt = $data->createdAt;
        $response->updatedAt = $data->updatedAt;

        if (isset($data->totalAddresses)) {
            $response->totalAddresses = $data->totalAddresses;
        }

        return $response;
    }

    public function toAPIResponse($data)
    {
        $response = new stdClass();
        $response->id = $data->id;
        $response->email = $data->email;
        $response->fullName = $data->fullName;
        $response->phone = $data->phone;

        return $response;
    }

    public function cleanModel()
    {
        $this->email = NULL;
        $this->password = NULL;
        $this->fullName = NULL;
        $this->phone = NULL;
        $this->isAdmin = NULL;
        $this->hasSystemAccess = NULL;
        $this->isProvider = NULL;
        $this->active = NULL;
        $this->createdAt = NULL;
        $this->updatedAt = NULL;
    }
}
