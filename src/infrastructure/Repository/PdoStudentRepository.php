<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infrastructure\ConnectionCreator;

class PdoStudentRepository implements StudentRepository
{
    private \PDO $connection;

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name birth_date) VALUES (:name, :birth_date);';
        $stmt = $this->connection->prepare($insertQuery);

        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format(format:'Y-m-d'),
        ]);

        $student->defineId($this->connection->lasInsertId());

        return $success;
    }

    public function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(parameter:':name', $student->name());
        $stmt->bindValue(parameter:':birth_date', $student->birthDate()->format(format:'Y-m-d'));
        $stmt->bindValue(parameter:':id', $student->id(), data_type:PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare(statement: 'DELETE FROM students WHERE id = ?;');
        $stmt->bindValue(parameter: 1, $student->id(), data_type: PDO::PARAM_INT_);

        return $stmt->execute();
    }

}