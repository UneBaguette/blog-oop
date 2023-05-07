<?php

namespace App\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;

class BlogController extends Controller {

    public function welcome()
    {
        return $this->view('blog.welcome');
    }

    public function index()
    {
        $post = new Post($this->getDB());
        $path = (new Image($this->getDB()))->getthumbnail("large");

        $posts = $post->all();

        return $this->view('blog.index', compact('posts', 'path'));
    }

    public function show(int $id)
    {
        $post = (new Post($this->getDB()))->findById($id);
        $path = (new Image($this->getDB()))->getthumbnail("large");

        return $this->view('blog.show', compact('post', 'path'));
    }

    public function tag(int $id)
    {
        $tag = (new Tag($this->getDB()))->findById($id);

        return $this->view('blog.tag', compact('tag'));
    }
}