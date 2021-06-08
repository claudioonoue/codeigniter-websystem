<?php

class User extends CW_Model
{
    private $id;
    private $email;
    private $password;
    private $fullName;
    private $phone;
    private $hasSystemAccess;
    private $isProvider;
    private $active;
    private $createdAt;
    private $updatedAt;

    public function fetch()
    {
        $sql = <<<SQL
            SELECT * 
            FROM users u;
        SQL;
        $query = $this->db->query($sql);
        $formatedResults = [];

        foreach ($query->result_array() as $row) {
            array_push($formatedResults, $this->toResponse($row));
        }

        return $formatedResults;
    }

    public function fetchById($id)
    {
        $sql = <<<SQL
            SELECT * 
            FROM users u
            WHERE u.id = ?;
        SQL;
        $query = $this->db->query($sql, [$id]);

        $row = $query->row_array();

        return isset($row) ? $this->toResponse($row) : [];
    }

    public function insert()
    {
        $sql = <<<SQL
            INSERT INTO users (
                email,
                password,
                fullName,
                phone,
                hasSystemAccess,
                isProvider,
                active,
                createdAt,
                updatedAt
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
        SQL;
        $query = $this->db->query($sql, [
            $this->email,
            $this->password,
            $this->fullName,
            $this->phone,
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
                fullName = ?,
                phone = ?,
                hasSystemAccess = ?,
                isProvider = ?,
                active = ?,
                updatedAt = ?
            WHERE u.id = ?;
        SQL;
        $query = $this->db->query($sql, [
            $this->fullName,
            $this->phone,
            $this->hasSystemAccess,
            $this->isProvider,
            $this->active,
            $this->updatedAt,
            $id
        ]);
        return $query;
    }

    public function prepare($operation, $fields)
    {
        $this->fullName = trim($fields['fullName']);
        $this->phone = trim($fields['phone']);
        $this->hasSystemAccess = $fields['hasSystemAccess'] ? 1 : 0;
        $this->isProvider = $fields['isProvider'] ? 1 : 0;
        $this->active = $fields['active'] ? 1 : 0;
        $now = new DateTime();
        if ($operation === 'insert') {
            $this->email = trim($fields['email']);
            $this->password = password_hash($fields['password'], PASSWORD_BCRYPT);
            $this->createdAt = $now->format(DATE_ATOM);
            $this->updatedAt = $now->format(DATE_ATOM);
        } elseif ($operation === 'update') {
            $this->updatedAt = $now->format(DATE_ATOM);
        }
    }

    public function toResponse($data)
    {
        return [
            'id' => $data['id'],
            'email' => $data['email'],
            'fullName' => $data['fullName'],
            'phone' => $data['phone'],
            'hasSystemAccess' => $data['hasSystemAccess'],
            'isProvider' => $data['isProvider'],
            'active' => $data['active'],
            'createdAt' => $data['createdAt'],
            'updatedAt' => $data['updatedAt']
        ];
    }
}
