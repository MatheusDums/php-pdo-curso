<?php

require 'vendor/autoload.php';
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->query('SELECT * FROM students');

$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

foreach($studentDataList as $studentData) {
    $studentList[] = new Student($studentData['id'], $studentData['name'], new \DateTimeImmutable($studentData['birth_date']));
}

var_dump($studentList);