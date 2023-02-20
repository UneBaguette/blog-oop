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

<form method="POST" name="postlink" action="<?= isset($params['post']) ? HREF_ROOT."admin/posts/edit/{$params['post']->id}?onpage=" . ($onpage ? "true":"false")  :  HREF_ROOT."admin/posts/create" ?>" >
    <div class="form-element">
        <label for="title">Titre de l'article</label>
        <input required="required" type="text" class="form-input" name="title" id="title" value="<?= $params['post']->title ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="content">Contenu de l'article</label>
        <textarea required="required" minlength="1" name="content" id="content" rows="8" class="form-input"><?= $params['post']->content ?? '' ?></textarea>
    </div>
    <div class="form-element">
        <label for="tags">Tags de l'article</label>
        <fieldset class="form-input select" id="tags" name="tags">
            <?php foreach($params['tags'] as $tag): ?>
                <div class="tag admin <?php if (isset($params['post'])) : ?>
                        
                        <?php foreach ($params['post']->getTags() as $postTag) {
                            echo ($tag->id === $postTag->id) ? 'active' : '';
                        }
                    ?>">
                    <?php endif; ?>
                    <label for="tags[]"><?= $tag->name ?></label>
                    <input name="tags[]" class="box" 
                    <?php if (isset($params['post'])) : ?>
                        
                        <?php foreach ($params['post']->getTags() as $postTag) {
                            echo ($tag->id === $postTag->id) ? 'checked="checked"' : '';
                        }
                    ?>
                    <?php endif; ?> 
                    type="checkbox" value="<?= $tag->id ?>">
                </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
    <div class="form-element img">
        <button class="btn add">Ajouter une image existante</button>
        <label for="images">Images de l'article</label>
        <div class="form-input" id="img-container">
            <?php if (isset($params['post']) && !empty($params['post']->getImages())) { ?>
                <?php foreach ($params['post']->getImages() as $postImg): ?>
                    <div class="img-content">
                        <div class="img-infos">
                            <img id="<?= $postImg->id ?>" alt="<?= htmlspecialchars($postImg->alt) ?>" src="<?= SCRIPTS . "images/" . $postImg->filename  ?>">
                            <p class="uploaded-filename"><?= $postImg->filename ?></p>
                            <div class="actions">
                                <button class="img-edit">
                                    Edit
                                </button>
                                <button class="img-trash">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <input style="display: none;" type="text" name="filename[]" id="filename" value="<?= $postImg->filename ?>">
                <?php endforeach; ?>
            <?php } else {?>
                <div class="img-content">
                    <input style="display: none;" type="text" name="filename[]" id="filename" value="">
                </div>
            <?php }; ?>
        </div>
        <span class="btn btn-file">
            <img src="<?= SCRIPTS . "content/icons8-plus-96.svg" ?>">
            <input type="file" class="img-add" accept="image/*">
        </span>
    </div>
    <button type="submit"  class="btn-form"><?= isset($params['post']) ? "Enregistrer les modifications" : "Enregistrer mon article" ?></button>
</form>
<script src="<?= SCRIPTS ?>js/load.js"></script>
<script src="<?= SCRIPTS ?>js/add.js"></script>