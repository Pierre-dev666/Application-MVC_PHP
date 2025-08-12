<?php
return [
  'db' => [
    'dsn' => 'mysql:host=localhost;port=3307;dbname=application_mvc_php;charset=utf8mb4',
    'user' => 'pierre',
    'pass' => 'Firefox.06',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ],
  ],
];
