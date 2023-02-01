<?php
require_once __DIR__ . "/vendor/autoload.php";
require __DIR__ . '/app/Models/User.php';

$db = new Database\DBConnection("blog_oop", "127.0.0.1", "root", "");

$cu = new App\models\User($db);
$cu::test();