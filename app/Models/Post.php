<?php

namespace App\Models;

use DateTime;

class Post extends Model {

    protected $table = 'posts';
    public $created_at;
    public $content;

    public function getCreatedAt(): string
    {
        return (new DateTime($this->created_at))->format('d/m/Y à H:i');
    }

    public function getExcerpt(): string
    {
        return substr($this->content, 0, 200) . '...';
    }

    public function getButton(): string
    {
        return '<a href="'.HREF_ROOT.'posts/'.$this->id.'" class="btn btn-post">Lire l\'article</a>';
    }

    public function getImage(): string
    {
        $imgs = $this->getImages();
        if (!empty($imgs)){
            foreach($imgs as $img){
                return '<img width="200" alt="'. $img->alt .'" src="'.SCRIPTS.'images/'.$img->filename.'" >';
            }
        }
        return "";
    }

    /**
     * Summary of getTags
     * 
     * @return mixed
     */
    public function getTags()
    {
        return $this->query("
            SELECT t.* FROM tags t
            INNER JOIN post_tag pt ON pt.tag_id = t.id
            WHERE pt.post_id = ?
        ", [$this->id]);
    }
    public function getImages()
    {
        return $this->query("
            SELECT i.* FROM media AS i
            INNER JOIN post_media AS pt ON pt.media_id = i.id
            WHERE pt.post_id = ?
        ", [$this->id]);
    }

    public function getTagById(int $id)
    {
        $st = $this->query("
            SELECT t.* FROM tags t
            INNER JOIN post_tag pt ON pt.tag_id = t.id
            WHERE pt.post_id = ?
        ", [$id]);
        $tags = array();
        foreach ($st as $v){
            array_push($tags, $v->name);
        }
        return $tags;
    }

    public function create(array $data, ?array $relations = null)
    {
        parent::create($data);

        $id = $this->db->getPDO()->lastInsertId();

        foreach ($relations as $tagId) {
            $stmt = $this->db->getPDO()->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$id, $tagId]);
        }

        return true;
    }

    public function update(int $id, mixed $data, ?array $relations = null)
    {
        parent::update($id, $data);

        $stmt = $this->db->getPDO()->prepare("DELETE FROM post_tag WHERE post_id = ?");
        $result = $stmt->execute([$id]);

        foreach ($relations as $tagId) {
            $stmt = $this->db->getPDO()->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$id, $tagId]);
        }

        if ($result) {
            return true;
        }
        return false;

    }
}