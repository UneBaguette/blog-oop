<h1><?= $params['post']->title ?></h1>

<div>
    <?php foreach($params['post']->getTags() as $tag): ?>
        <span class="tag"><a href="<?= HREF_ROOT ?>tags/<?= $tag->id ?>" class="link"><?= $tag->name ?></a></span>
    <?php endforeach ?>
</div>
<p><?= $params['post']->content ?></p>
<?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1): ?>

<a href="<?= HREF_ROOT ?>admin/posts/edit/<?= $params['post']->id ?>?onpage=true" class="edit btn">Éditer</a>

<?php endif; ?>
<a href="<?= HREF_ROOT ?>posts" class="btn">Retourner en arrière</a>

<section class="section-img">
    <h2>Images<span id="count-img">(2)</span></h2>
    <ul class="img-container">
        <!-- MODEL -->
        <!-- <li>
            <img src="/public/images/lonely.gif">
            <div class="overlay">
                <p>Test</p>
            </div>
        </li> -->
        <!-- MODEL -->
        <li>
            <img src="/public/images/lonely.gif">
            <div class="overlay-vignette">
                <p>Bob</p>
            </div>
        </li>
        <li>
            <img src="/public/images/bat.gif">
            <div class="overlay-vignette">
                <p>Batman</p>
            </div>
        </li>
    </ul>
    <div class="overlay hidden">
        
    </div>
</section>

