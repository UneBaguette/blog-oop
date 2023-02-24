<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller {

    public function index()
    {
        $this->isAdmin();

        $tags = (new Tag($this->getDB()))->all();

        return $this->view('admin.tag.index',  compact('tags'));
    }

    public function create()
    {
        $this->isAdmin();

        $tags = (new Tag($this->getDB()))->all();

        return $this->view('admin.tag.form', compact('tags'));
    }

    public function createTag()
    {
        $this->isAdmin();

        $tag = new Tag($this->getDB());

        $tags = null;

        if (count($_POST) > 1) {
            $tags = array_pop($_POST);
        }

        $result = $tag->create($_POST, $tags);

        if ($result) {
            return header('Location: /admin/tags');
        }
    }

    public function edit(int $id)
    {
        $this->isAdmin();

        $tag = (new Tag($this->getDB()))->findById($id);

        return $this->view('admin.tag.form', compact('tag'));
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $tag = new Tag($this->getDB());

        if (count($_POST) > 1) {
            $post = array_pop($_POST);
        }

        $result = $tag->update($id, $_POST, $post);

        if ($result) {
            return header('Location: /admin/tags');
        }
    }

    public function destroy(int $id)
    {
        $this->isAdmin();
        header('Access-Control-Allow-Methods: DELETE');
        header('Content-Type: application/json; charset=utf-8');

        $tag = new Tag($this->getDB());
        $result = $tag->destroy($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(["success" => 0]);
            exit;
        }
        http_response_code(403);
        echo json_encode(["error" => 0]);
        exit(1);
    }
}