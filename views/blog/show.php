<h1><?= $params['post']->title ?></h1>
<div>
    <?php foreach ($params['post']->getTags() as $tag) : ?>
        <span class="badge badge-info"><?= $tag->name ?></span>
    <?php endforeach ?>
</div>
<p><?= $params['post']->content ?></p>
<?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1): ?>

<a href="<?= HREF_ROOT ?>admin/posts/edit/<?= $params['post']->id ?>?onpage=true" class="edit btn btn-secondary">Éditer</a>

<?php endif; ?>
<a href="<?= HREF_ROOT ?>posts" class="btn btn-secondary">Retourner en arrière</a>