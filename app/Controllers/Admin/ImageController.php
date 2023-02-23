<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Image;

class ImageController extends Controller {

    public function index()
    {
        $this->isAdmin();

        $images = (new Image($this->getDB()))->all();
        $path = (new Image($this->getDB()))->path;

        return $this->view('admin.image.index',  compact('images', 'path'));
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

        if ($fileIsUploaded) {
            $name = $filename = $_FILES["file"]["name"];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (isset($_POST['rename'])){
                array_pop($_POST);
                $lowerName = strtolower(basename($_POST["name"])) . "." . $extension;
                $name = str_replace(" ", "_", $lowerName);
            }
            if (file_exists($image->path . $name)) {
                $increment = 0;
                while(file_exists($image->path . $name)) {
                    $name = $lowerName;
                    $increment++;
                    $name = explode(".", $name)[0] . + $increment . "." . $extension;
                }
            }
            $_POST["filename"] = $name;

            move_uploaded_file($_FILES["file"]["tmp_name"], $image->path . $name);

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

        //TODO: fix update image

        $result = $image->update($id, $_POST);

        if ($result) {
            return header('Location: /admin/images');
        }
    }

    public function destroy(int $id)
    {
        $this->isAdmin();
        header('Access-Control-Allow-Methods: DELETE');
        header('Content-Type: application/json; charset=utf-8');

        $image = new Image($this->getDB());
        $filename = $image->getFilenameById($id)->filename;
        
        if ($image->destroy($id)) {
            if (file_exists($image->path . $filename)){
                if (unlink($image->path . $filename)){
                    http_response_code(200);
                    echo json_encode(["success" => 0]);
                    exit();
                }
                http_response_code(207);
                echo json_encode(["success" => 1]);
                exit(1);
            }
            http_response_code(207);
            echo json_encode(["success" => 2]);
            exit(1);
        }
        http_response_code(404);
        echo json_encode(["error" => 0]);
        exit(1);
    }
}