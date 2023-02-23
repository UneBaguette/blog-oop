<?php

namespace App\Models;

class Image extends Model {
    protected $table = 'media';

    public $path = ROOT . "/public/images/";

    public function getFilenameById(int $id)
    {
        return $this->query("SELECT filename FROM media WHERE id = ?", [$id], true);
    }
}