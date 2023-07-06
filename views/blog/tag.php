<button onclick="history.back()" class="btn">⬅ Back</button>

<h1><?= ucfirst($params['tag']->name) ?></h1>

<?php foreach ($params['tag']->getPosts() as $post) : ?>
    <div class="post row">
        <div class="post-body">
            <a><a href="<?= HREF_ROOT ?>posts/<?= $post->id ?>"><?= $post->title ?></a></a>
        </div>
    </div>
<?php endforeach; ?>
