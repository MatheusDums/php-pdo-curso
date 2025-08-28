<?php

require 'vendor/autoload.php';
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\infrastructure\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$preparedStatement = $pdo->prepare('DELETE FROM students WHERE id = ? ;');
$preparedStatement->bindValue(1, 5, PDO::PARAM_INT);
var_dump($preparedStatement->execute());