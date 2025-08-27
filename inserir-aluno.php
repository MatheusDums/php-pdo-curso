<?php

require 'vendor/autoload.php';
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$student = new Student(null, 'Matheus Kauan Dums', new \DateTimeImmutable('2004-07-03'));

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?);";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));
$statement->execute();

if($statement->execute()) {
    echo "Aluno Incluído";
}