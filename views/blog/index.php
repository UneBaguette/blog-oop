<?php $path = ($params['path'] ?? ""); $posts = ($params['posts'] ?? "") ?>

<h1>Les derniers articles</h1>

<?php foreach ($posts as $post): $imgs = $post->getImages(); ?>
    <article class="post">
        <div class="post-body">
            <h2><?= $post->title ?></h2>
            <div class='post-info'>
                <div>
                    <?php foreach ($post->getTags() as $tag) : ?>
                        <span><a href="<?= HREF_ROOT ?>tags/<?= $tag->id ?>" class="link tag"><?= $tag->name ?></a></span>
                    <?php endforeach ?>
                </div>
                <small class="published">Publié le <?= $post->getCreatedAt(); ?></small>
            </div>
            <p><?= $post->getExcerpt(); ?></p>
            <?= $post->getButton(); ?>
        </div>
        <?php if ($imgs): $limit = (count($imgs) > 10 ? 10 : count($imgs)); ?>
            <div class="post-imgs">
                <noscript>
                    <?= $post->getImage() ?>
                </noscript>
                <div class="thumbnail-container">
                    <?php for ($i = 0; $i < $limit; $i++): $img = $imgs[$i]; ?>
                        <span class="img<?= $i === 0 ? ' primary': '' ?>">
                            <img width="200" src="<?= $path . $img->filename ?>" alt="<?= $img->alt ?>">
                        </span>
                    <?php endfor; ?>
                </div>
                <div class="actions-dot">
                    <?php for($i = 0; $i < $limit; $i++): ?>
                        <span <?= $i === 0 ? 'class="selected"' : ''; ?>></span>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </article>
<?php endforeach ?>

<span>Showing 1-<?= count($posts)?></span>

<script>
// VERSION 0.1
(function() {
    'use strict';

    const thumbcontainer = document.querySelectorAll('.thumbnail-container');

    thumbcontainer.forEach((container, idx) => {
        // Second delay
        const delay = 5;
        const dots = Array.from(container.parentNode.children).filter(item => item.className === 'actions-dot')[0];
        if (Array.from(container.children).length <= 1)
            return;
        slidingImages(container, Array.from(container.children), dots, delay * 1000);
    });

    function slidingImages(parent, imgs, blocks, timer)
    {
        const idx = imgs.length - 1;
        let selected = 0;
        let nextSelect = selected + 1 > idx ? 0 : selected + 1;
        const interval = setInterval(() => {
            const img = imgs[selected];
            const nextImg = imgs[nextSelect];
            const dot = blocks.children[selected];
            const nextDot = blocks.children[nextSelect];
            nextImg.classList.add('primary');
            if (nextSelect === 0 && selected !== nextSelect){
                nextImg.classList.add('first');
                img.classList.add('last');
            }
            nextDot.classList.add('selected');
            parent.classList.add("transition");
            selected = selected >= idx ? 0 : selected + 1;
            nextSelect = selected + 1 > idx ? 0 : selected + 1;
            dot.classList.add('fade');
            setTimeout(() => {
                parent.classList.remove("transition");
                img.classList.remove('primary');
                dot.classList.remove('selected');
                dot.classList.remove('fade');
                nextImg.classList.remove('first');
                img.classList.remove('last');
            }, 600);
        }, timer);
    };

})();
</script>