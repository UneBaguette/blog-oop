<?php

namespace App\Controllers;

use Database\DBConnection;
// TODO:remove
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
        // var_dump("Controller view",VIEWS , $path);
        //die();
        require VIEWS . $path . '.php';
        $content = ob_get_clean();
        require VIEWS . 'layout.php';
    }

    protected function getDB()
    {
        return $this->db;
    }

    protected function isAdmin()
    {
        if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth'] === 1){
                return true;
            }
            return header('Location: /');
        }
        return header('Location: /login');
    }
}
