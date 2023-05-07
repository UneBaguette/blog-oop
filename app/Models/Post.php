<?php

namespace App\Models;

use DateTime;

class Post extends Model {
    /**
     * Table de la base de donnée
     * @var string
     */
    protected $table = 'posts';
    /**
     * La date de création de l'article
     * @var string
     */
    public $created_at;
    /**
     * Le contenu de l'article
     * @var string
     */
    public $content;
    /**
     * Id de l'article
     * @var string
     */
    public $id;
    /**
     * Récupère la date de création de l'article
     * @return string La date de création de l'article
     */
    public function getCreatedAt(): string
    {
        return (new DateTime($this->created_at))->format('d/m/Y à H:i');
    }
    public function getExcerpt(): string
    {
        if (strlen($this->content) > 200){
            return substr($this->content, 0, 200) . '...';
        }
        return $this->content;
    }
    public function getButton(): string
    {
        return '<a href="'.HREF_ROOT.'posts/'.$this->id.'" class="btn btn-post">Lire l\'article</a>';
    }

    public function getImage(): string
    {
        $imgs = $this->getImages();
        if (!empty($imgs)){
            return '<img width="200" alt="'. $imgs[0]->alt .'" src="'.(new Image($this->db))->getthumbnail("large").''.$imgs[0]->filename.'" >';
        }
        return "";
    }
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
    public function getTagById(int $id): Array
    {
        $st = $this->query("
            SELECT t.* FROM tags t
            INNER JOIN post_tag pt ON pt.tag_id = t.id
            WHERE pt.post_id = ?
        ", [$id]);
        $tags = array();
        foreach ($st as $v){
            array_push($tags, ["id" => $v->id, "name" => $v->name]);
        }
        return $tags;
    }

    public function create(array $data, ?array $relations = null): bool
    {
        parent::create($data);

        $id = $this->db->getPDO()->lastInsertId();

        //TODO: Better code
        foreach ($relations as $k => $v) {
            if ($k === "tags"){
                foreach($v as $v) {
                    $stmt = $this->db->getPDO()->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
                    $stmt->execute([$id, $v]);
                }
            } else if ($k === "media"){
                foreach($v as $v) {
                    if ($v !== ""){
                        $stmt = $this->db->getPDO()->prepare("INSERT post_media (post_id, media_id) VALUES (?, ?)");
                        $stmt->execute([$id, $v]);
                    }
                }
            }
        }

        return true;
    }

    public function update(int $id, mixed $data, ?array $relations = null): bool
    {
        parent::update($id, $data);

        $stmt = $this->db->getPDO()->prepare("DELETE FROM post_tag WHERE post_id = ?; DELETE FROM post_media WHERE post_id = ?;");
        $result = $stmt->execute([$id, $id]);

        //TODO: Better code
        foreach ($relations as $k => $v){
            if ($k == "tags"){
                foreach($v as $v) {
                    $stmt = $this->db->getPDO()->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
                    $stmt->execute([$id, $v]);
                }
            } else if ($k == "media"){
                foreach($v as $v) {
                    if ($v != ""){
                        $stmt = $this->db->getPDO()->prepare("INSERT post_media (post_id, media_id) VALUES (?, ?)");
                        $stmt->execute([$id, $v]);
                    }
                }
            }
        }

        if ($result) {
            return true;
        }
        return false;

    }
}