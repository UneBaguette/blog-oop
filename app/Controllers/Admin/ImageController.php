<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Image;

class ImageController extends Controller {

    public function index()
    {
        $this->isAdmin();

        $images = (new Image($this->getDB()))->all();

        return $this->view('admin.image.index',  compact('images'));
    }

    public function create()
    {
        $this->isAdmin();

        $images = (new Image($this->getDB()))->all();

        return $this->view('admin.image.form', compact('images'));
    }

    public function createImage()
    {
        $this->isAdmin();

        $fileIsUploaded = isset($_FILES['file']) && (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name']));

        $image = new Image($this->getDB());

        $rename = array_pop($_POST);

        if ($fileIsUploaded) {
            $filename = $_FILES["file"]["name"];
            $imagePath = ROOT . "/public/images/";
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $lowerName = strtolower(basename($_POST["name"])) . "." . $extension;
            $name = str_replace(" ", "_", $lowerName);
            if (file_exists($imagePath . $name)) {
                $increment = 0;
                while(file_exists($imagePath . $name)) {
                    $name = $lowerName;
                    $increment++;
                    $name = explode(".", $name)[0] . + $increment . "." . $extension;
                }
            }
            $_POST["filename"] = $name;

            move_uploaded_file($_FILES["file"]["tmp_name"], $imagePath . $name);

            $result = $image->create($_POST);

            if ($result) {
                return header('Location: /admin/images');
            }
        }
        return header('Location: /admin/images?error=true');
    }

    public function edit(int $id)
    {
        $this->isAdmin();

        $image = (new Image($this->getDB()))->findById($id);

        return $this->view('admin.image.form', compact('image'));
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $image = new Image($this->getDB());

        if (count($_POST) > 1) {
            $post = array_pop($_POST);
        }

        $result = $image->update($id, $_POST, $post);

        if ($result) {
            return header('Location: /admin/images');
        }
    }

    public function destroy(int $id)
    {
        $this->isAdmin();

        $image = new Image($this->getDB());
        $result = $image->destroy($id);

        if ($result) {
            return header('Location: /admin/images');
        }
    }
}