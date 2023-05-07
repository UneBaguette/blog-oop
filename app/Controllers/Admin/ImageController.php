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
        $path = (new Image($this->getDB()))->getthumbnail();

        return $this->view('admin.image.form', compact('images', 'path'));
    }

    public function createImage()
    {
        $this->isAdmin();

        $fileIsUploaded = isset($_FILES['file']) && (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name']));

        $image = new Image($this->getDB());
        $path = $image->getfullpath();

        if ($fileIsUploaded) {
            $newName = $image->getNewFileName($_FILES["file"]["name"]);
            $_POST["filename"] = $newName;

            move_uploaded_file($_FILES["file"]["tmp_name"], $path . $newName);

            $image->resizeImage($newName, $path, 0.2);
            $image->resizeImage($newName, $path, 0.65, "large");

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
        $path = (new Image($this->getDB()))->getthumbnail();

        return $this->view('admin.image.form', compact('image', 'path'));
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $image = new Image($this->getDB());
        $path = $image->getfullpath();

        $ogName = $_POST['filename'];
        $newName = $image->getNewFileName($_POST['filename']);
        $_POST["filename"] = $newName;

        if (rename($path . $ogName, $path . $newName)) {
            $result = $image->update($id, $_POST);

            if ($result) {
                return header('Location: /admin/images');
            }
            return header('Location: /admin/images?error=true');
        }
        return header('Location: /admin/images?error=true');
    }

    public function destroy(int $id)
    {
        $this->isAdmin();
        header('Access-Control-Allow-Methods: DELETE');
        header('Content-Type: application/json; charset=utf-8');

        $image = new Image($this->getDB());
        $filename = isset($image->getFilenameById($id)->filename) ? $image->getFilenameById($id)->filename : NULL;
        $path = $image->getfullpath();
        $paths = [$path, $path . "thumb/large/", $path . "thumb/small/"];

        if (!isset($filename)){
            echo json_encode(["error" => true, "msg" => "L'image n'a pas été trouvé"]);
            http_response_code(404);
            exit(1);
        }
        
        if ($image->destroy($id)) {
            if ($image->fileExistsOnAllPaths($filename, $path, $paths)){
                if ($image->deleteAllFilesOnPaths($filename, $path, $paths)){
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
        http_response_code(404);
        echo json_encode(["error" => "Les images n'ont pas été trouvés !"]);
        exit(1);
    }

    public function getFullImagesPath()
    {
        $image = (new Image($this->getDB()));
        echo json_encode(['path' => $image->getpath(), 'fullpath' => $image->getfullpath(), "thumb" => array("large" => $image->getthumbnail("large"), "small" => $image->getthumbnail())]);
        exit();
    }
}