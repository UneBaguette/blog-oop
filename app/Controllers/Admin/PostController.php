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
        $path = (new Image($this->getDB()))->getthumbnail();

        return $this->view('admin.post.form', compact('tags', 'path'));
    }

    public function createPost()
    {
        $this->isAdmin();

        $post = new Post($this->getDB());

        $tags = array();
        $media = array();

        // TODO: Better code
        if (isset($_POST['tags'])) {
            $tags = $_POST['tags'];
            unset($_POST['tags']);
        }
        if(isset($_POST['media'])){
            $media = $_POST['media'];
            unset($_POST['media']);
        }

        $result = $post->create($_POST, ["tags" => $tags, "media" => $media]);

        if ($result) {
            return header('Location: /admin/posts');
        }
        return header('Location: /admin/posts?error=true');
    }

    public function edit(int $id)
    {
        $this->isAdmin();

        $post = (new Post($this->getDB()))->findById($id);
        $tags = (new Tag($this->getDB()))->all();
        $image = (new Image($this->getDB()))->all();
        $path = (new Image($this->getDB()))->getthumbnail();

        $postTag = (new Post($this->getDB()))->getTagById($id);

        foreach($tags as $tag){
            foreach($postTag as $pTag){
                if (in_array($tag->id, $pTag)){
                    $tag->active = true;
                }
            }
        }
        
        return $this->view('admin.post.form', compact('post', 'tags', 'image', 'path'));
    }

    public function update(int $id)
    {
        $this->isAdmin();

        $onpage = (bool)(filter_var(($_GET['onpage'] ?? ""), FILTER_VALIDATE_BOOLEAN));

        $post = new Post($this->getDB());

        $tags = array();
        $media = array();

        if (isset($_POST['tags'])) {
            $tags = $_POST['tags'];
            unset($_POST['tags']);
        }
        if (isset($_POST['media'])){
            $media = $_POST['media'];
            unset($_POST['media']);
        }

        $result = $post->update($id, $_POST, ["tags" => $tags, "media" => $media]);

        if ($result) {
            if ($onpage){
                return header('Location: /posts/' . $id);
            }
            return header('Location: /admin/posts');
        }
        return header('Location: /admin/posts?error=true');
    }

    public function destroy(int $id): void
    {
        $this->isAdmin();
        header('Access-Control-Allow-Methods: DELETE');
        header('Content-Type: application/json; charset=utf-8');

        $post = new Post($this->getDB());
        $result = $post->destroy($id);

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