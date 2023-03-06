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
        $path = $image->getpath();

        if ($fileIsUploaded) {
            $name = $filename = $_FILES["file"]["name"];
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (isset($_POST['rename'])){
                unset($_POST['rename']);
                $lowerName = strtolower(basename($_POST["name"])) . "." . $extension;
                $name = str_replace(" ", "_", $lowerName);
            }
            if (!isset($_POST['overwrite']) && file_exists($path . $name)) {
                $increment = 0;
                while(file_exists($path . $name)) {
                    $name = $lowerName;
                    $increment++;
                    $name = explode(".", $name)[0] . + $increment . "." . $extension;
                }
            }
            unset($_POST['overwrite']);
            $_POST["filename"] = $name;

            move_uploaded_file($_FILES["file"]["tmp_name"], $path . $name);

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

        //TODO: update image when new one is uploaded

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
        $filename = isset($image->getFilenameById($id)->filename) ? $image->getFilenameById($id)->filename : NULL;
        $path = $image->getpath();

        if (!isset($filename)){
            echo json_encode(["error" => true, "msg" => "L'image n'a pas été trouvé"]);
            http_response_code(404);
            exit(1);
        }
        
        if ($image->destroy($id)) {
            if (file_exists($path . $filename)){
                if (unlink($path . $filename)){
                    http_response_code(200);
                    echo json_encode(["error" => false, "msg" => "L'image et son fichier ont été supprimé avec succès !"]);
                    exit();
                }
                http_response_code(207);
                echo json_encode(["error" => true, "msg" => "L'image a été supprimé mais erreur lors de la suppression du fichier."]);
                exit(1);
            }
            http_response_code(207);
            echo json_encode(["error" => true, "msg" => "L'image a été supprimé mais le fichier n'a pas été trouvé."]);
            exit(1);
        }
        http_response_code(403);
        echo json_encode(["error" => true, "msg" => "La suppression n'a pas été possible"]);
        exit(1);
    }

    public function allImages()
    {
        $this->isAdmin();

        $images = (new Image($this->getDB()))->all();

        if ($images){
            http_response_code(200);
            echo json_encode($images);
            exit;
        }
        http_response_code(403);
        echo json_encode(["error" => "Les images n'ont pas été trouvés !"]);
        exit(1);
    }
}