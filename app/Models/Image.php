<?php

namespace App\Models;

class Image extends Model {
    protected $table = 'media';

    private $path = "/public/images/";
    /**
     * Id de l'image
     * @var string
     */
    public $id;

    public function getFilenameById(int $id)
    {
        return $this->query("SELECT filename FROM media WHERE id = ?", [$id], true);
    }

    public function getfullpath(): string
    {
        return ROOT . $this->path;
    }

    public function getpath(): string
    {
        return $this->path;
    }

    public function getthumbnail(string $folder = "small"): string
    {
        return $this->path . "thumb/" . $folder . "/";
    }

    public function getfullthumbnail(string $folder = "small"): string
    {
        return ROOT . $this->path . "thumb/" . $folder . "/";
    }

    /**
     * Permet de savoir si oui ou non il y a d'autres images avec le même nom de fichier
     * @return bool La valeur en boolean si il y a d'autres images avec le même nom de fichier
     */
    public function hasMultipleSameFilename(string $filename): bool
    {
        return count($this->query("SELECT id, filename FROM media WHERE filename = ?", [$filename])) > 0;
    }

    public function getNewFileName(string $oldName): string
    {
        $path = $this->getfullpath();
        $name = $filename = $oldName;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $lowerName = strtolower(basename($_POST["name"])) . "." . $extension;
        if (isset($_POST['rename'])) {
            unset($_POST['rename']);
            $name = str_replace(" ", "_", $lowerName);
        }
        if (!isset($_POST['overwrite']) && file_exists($path . $name) && $this->hasMultipleSameFilename($name)) {
            $increment = 0;
            while(file_exists($path . $name)) {
                $name = $lowerName;
                $increment++;
                $name = explode(".", $name)[0] . + $increment . "." . $extension;
            }
            $name = str_replace(" ", "_", $name);
        }
        unset($_POST['overwrite']);
        return $name;
    }

    // OLD -- WIP
    public function resizeImageOld(string $filename, string $pathfile, float $percent = 0.5, string $folder = "small")
    {
        $pathFileName = $pathfile . $filename;
        list($width, $height) = getimagesize($pathFileName);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromstring(file_get_contents($pathFileName));
        var_dump($pathFileName);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagegd2($thumb, ROOT . $this->getthumbnail($folder) . $filename);
    }

    // WIP
    public function resizeImage(string $filename, string $pathfile, float $percent = 0.5, string $folder = "small"): bool
    {
        $image = new \Imagick();
        $file_dst = $this->getfullthumbnail($folder) . $filename;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $image->readImage($pathfile . $filename);
        $width = $image->getImageWidth() * $percent;
        $height = $image->getImageHeight() * $percent;
        if ($ext === "gif"){
            $new = $image->coalesceImages();
            foreach ($new as $frame) {
                $frame->thumbnailImage($width, 0);
            }
            $new = $new->deconstructImages();
            return $new->writeImages($file_dst, true);
        }
        $image->thumbnailImage($width, 0);
        return $image->writeImage($file_dst);
    }

    public function fileExistsOnAllPaths(string $filename, string $homepath, array $allpaths): bool
    {
        foreach($allpaths as $path){
            if (!file_exists($path . $filename)){
                return false;
            };
        }
        return true;
    }

    public function deleteAllFilesOnPaths(string $filename, string $homepath, array $allpaths): bool
    {
        $success = true;
        foreach($allpaths as $path){
            $del = unlink($path . $filename);
            if (!$del)
                $success = false;
        }
        return $success;
    }
}