<h1><?= $params['post']->title ?></h1>

<?php 

$imgs = ($params['post']->getImages() ?? false);
$path = ($params['path'] ?? "");

?>

<div>
    <?php foreach($params['post']->getTags() as $tag): ?>
        <span><a href="<?= HREF_ROOT ?>tags/<?= $tag->id ?>" class="link tag"><?= $tag->name ?></a></span>
    <?php endforeach ?>
</div>
<p style="max-width: 900px"><?= $params['post']->content ?></p>
<?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1): ?>

<a href="<?= HREF_ROOT ?>admin/posts/edit/<?= $params['post']->id ?>?onpage=true" class="edit btn">Éditer</a>

<?php endif; ?>

<a href="<?= HREF_ROOT ?>posts" class="btn">Retourner en arrière</a>

<?php if ($imgs): ?>

<section class="section-img">
    <h2>Images (<?= count($imgs) ?>)</h2>
    <ul class="img-container">
        <?php foreach($imgs as $img): ?>
            <li>
                <img alt="<?= $img->alt ?>" src="<?= $path . $img->filename ?>">
                <div class="overlay-vignette">
                    <p><?= $img->name ?></p>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="overlay" style="display: none;">
        <button></button>
        <ul>
            <?php for($i = 0; $i < count($imgs); $i++): ?>
                <li data-id="<?= $i + 1 ?>">
                    <img alt="<?= $imgs[$i]->alt ?>" src="<?= $path . $imgs[$i]->filename ?>">
                    <div class="overlay-vignette">
                        <p><?= $imgs[$i]->name ?></p>
                    </div>
                </li>
            <?php endfor; ?>
        </ul>
        <button></button>
    </div>
</section>

<?php endif; ?>