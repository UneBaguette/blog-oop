<?php

namespace App\Controllers;

use Database\DBConnection;
use App\Exceptions\NotFoundException;
// TODO:remove this line if it is working without it
require __DIR__ . '/../Models/User.php';

abstract class Controller {

    protected $db;

    public function __construct(DBConnection $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }

    protected function view(string $path, array $params = null)
    {
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS . $path . '.php';
        $content = ob_get_clean();
        require VIEWS . 'layout.php';
    }

    protected function getDB(): DBConnection
    {
        return $this->db;
    }

    protected static function defaultPageUser(): string {
        return (($_SESSION['auth'] ?? 0) >= 1) ? '/admin' : '/posts';
    }

    protected static function redirectToMainPage() {
        return isset($_SESSION['auth']) && header('Location: ' . self::defaultPageUser());
    }

    protected function isAdmin()
    {
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] >= 1){
                return true;
            }
        }
        return NotFoundException::error404();
    }
}