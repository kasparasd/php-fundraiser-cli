<?php

namespace src\models;

use src\Model;

class Charity extends Model
{

    public function findAll()
    {
        $stmt = 'SELECT * FROM charities';
        $charities = $this->db->query($stmt)->fetchAll();

        return $charities;
    }
    public function store($name, $email)
    {
        $sql = "INSERT INTO charities (name, email) VALUES (:name, :email)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
    }
    public function update($id, $name, $email)
    {
        $sql = "UPDATE charities SET name = :name, email = :email WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }
    public function destroy($id)
    {
        $sql = "DELETE FROM charities WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM charities WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }
}
