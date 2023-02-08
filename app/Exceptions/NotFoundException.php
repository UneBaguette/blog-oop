<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception {

    public function __construct($message = "", $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function error404()
    {   
        ob_start();
        http_response_code(404);
      
        require VIEWS . 'errors/404.php';
        $content = ob_get_clean();
        require VIEWS . 'layout.php';
    }
}
