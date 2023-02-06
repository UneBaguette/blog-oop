<h1>Les derniers articles</h1>

<?php foreach ($params['posts'] as $post): ?>
    <div class="post">
        <div class="post-body">
            <h2><?= $post->title ?></h2>
            <div class='post-info'>
                <div>
                    <?php foreach ($post->getTags() as $tag) : ?>
                        <span class="tag"><a href="<?= HREF_ROOT ?>tags/<?= $tag->id ?>" class="link"><?= $tag->name ?></a></span>
                    <?php endforeach ?>
                </div>
                <small class="published">Publié le <?= $post->getCreatedAt(); ?></small>
            </div>
            <p><?= $post->getExcerpt(); ?></p>
            <?= $post->getButton(); ?>
        </div>
        <div class="post-img">
            <?= $post->getImage(); ?>
        </div>
    </div>
<?php endforeach ?>