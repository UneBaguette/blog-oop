<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Image;

class PostController extends Controller {

    public function index()
    {
        $this->isAdmin();

        $post = new Post($this->getDB());

        $posts = $post->all();

        foreach ($posts as $p){
            $p->tags = $post->getTagById($p->id);
        }

        return $this->view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $this->isAdmin();

        $tags = (new Tag($this->getDB()))->all();

        return $this->view('admin.post.form', compact('tags'));
    }

    public function createPost()
    {
        $this->isAdmin();

        $post = new Post($this->getDB());

        $tags = array_pop($_POST);

        $result = $post->create($_POST, $tags);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }

    public function edit(int $id)
    {
        $this->isAdmin();

        $post = (new Post($this->getDB()))->findById($id);
        $tags = (new Tag($this->getDB()))->all();
        $image = (new Image($this->getDB()))->all();
        
        return $this->view('admin.post.form', compact('post', 'tags', 'image'));
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $onpage = (bool)(filter_var(($_GET['onpage'] ?? ""), FILTER_VALIDATE_BOOLEAN));

        $post = new Post($this->getDB());

        $tags = array();

        if (!empty($_POST['tags'])) {
            $tags = array_pop($_POST);
        }

        $result = $post->update($id, $_POST, $tags);

        if ($result) {
            if ($onpage){
                return header('Location: /posts/' . $id);
            }
            return header('Location: /admin/posts');
        }
    }

    public function destroy(int $id)
    {
        $this->isAdmin();

        $post = new Post($this->getDB());
        $result = $post->destroy($id);

        if ($result) {
            return header('Location: /admin/posts');
        }
    }
}