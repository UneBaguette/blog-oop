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

<?php

?>

<h1><?= $params['post']->title ?? 'Créer un nouvel article' ?></h1>

<form method="POST" name="postlink" action="<?= isset($params['post']) ? HREF_ROOT."admin/posts/edit/{$params['post']->id}?onpage=" . ($onpage ? "true":"false")  :  "../../admin/posts/create" ?>" >
    <div class="form-element">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-input" name="title" id="title" value="<?= $params['post']->title ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="content">Contenu de l'article</label>
        <textarea name="content" id="content" rows="8" class="form-input"><?= $params['post']->content ?? '' ?></textarea>
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
    <div class="form-element">
        <label for="tags">Images de l'article</label>
        <div class="form-input">
            <section class="imgs-uploaded">
                <?php if (isset($params['post'])) : ?>
                <?php foreach ($params['post']->getImages() as $postImg) {
                    echo "<img alt='". htmlspecialchars($postImg->alt) ."' src='".SCRIPTS."images/". $postImg->filename ."' >";
                };
                ?>
                <?php endif; ?>
            </section>
            <input type="file" class="img-add">
        </div>
    </div>
    <button type="submit"  class="btn-form"><?= isset($params['post']) ? "Enregistrer les modifications" : "Enregistrer mon article" ?></button>
</form>