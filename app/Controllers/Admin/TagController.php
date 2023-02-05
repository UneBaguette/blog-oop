<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
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
        //return $this->view('admin.post.form', compact('post'));
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

        $tag = new Tag($this->getDB());
        $result = $tag->destroy($id);

        if ($result) {
            return header('Location: /admin/tags');
        }
    }
}
