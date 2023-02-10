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

        $image = new Image($this->getDB());

        $images = null;

        if (count($_POST) > 1) {
            $images = array_pop($_POST);
        }

        $result = $image->create($_POST, $images);

        if ($result) {
            return header('Location: /admin/images');
        }
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