<script language=javascript>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>

<?php $onpage = (bool)(filter_var(($_GET['onpage'] ?? ""), FILTER_VALIDATE_BOOLEAN)); if ($onpage) { ?>

    <a href="<?= HREF_ROOT . "posts/" . $params['post']->id ?>">⬅ Back to post</a>

<?php } else { ?>

    <a href="<?= HREF_ROOT . "admin/posts"?>">⬅ Back to panel</a>

<?php } ?>

<h1><?= $params['post']->title ?? 'Créer un nouvel article' ?></h1>

<form method="POST" name="postlink" action="<?= isset($params['post']) ? HREF_ROOT."admin/posts/edit/{$params['post']->id}?onpage=" . ($onpage ? "true":"false")  :  "../../admin/posts/create" ?>" >
    <div class="form-group">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= $params['post']->title ?? '' ?>">
    </div>
    <div class="form-group">
        <label for="content">Contenu de l'article</label>
        <textarea name="content" id="content" rows="8" class="form-control"><?= $params['post']->content ?? '' ?></textarea>
    </div>
    <div class="form-group">
        <label for="tags">Tags de l'article</label>
        <select multiple class="form-control" id="tags" name="tags[]">
            <?php foreach ($params['tags'] as $tag) : ?>
                <option value="<?= $tag->id ?>"
                <?php if (isset($params['post'])) : ?>
                <?php foreach ($params['post']->getTags() as $postTag) {
                    echo ($tag->id === $postTag->id) ? 'selected' : '';
                }
                ?>
                <?php endif ?>><?= $tag->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
    
    <button type="submit"  class="btn btn-primary"><?= isset($params['post']) ? "Enregistrer les modifications" : "Enregistrer mon article" ?></button>
    
    </form>




