<h1>Administration des articles</h1>

<?php if(isset($_GET['success'])): ?>
    <div class="msg success">Vous êtes connecté ! (Connecté en tant que "<?= $_SESSION['connectedas'] ?>")</div>
    <?php if (isset($_GET['registered'])): ?>
        <div class="msg success">Vous êtes enregistré avec succès !</div>
    <?php endif; ?>
<?php endif; ?>

<a href="<?= HREF_ROOT ?>admin/posts/create" class="btn">Créer un nouvel article</a>

<table class="table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="id">#</th>
            <th scope="col">Titre</th>
            <th scope="col">Tags</th>
            <th scope="col">Publié le</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($params['posts'] as $post): ?>
            <tr>
                <th scope="row" class="id"><?= $post->id; ?></th>
                <td><?= $post->title; ?></td>
                <td class="table-tags">
                    <?php foreach($post->tags as $tag): ?>
                        <span class="tag"><?= $tag ?></span>
                    <?php endforeach; ?>
                </td>
                <td><?= $post->getCreatedAt(); ?></td>
                <td class="actions">
                    <button data-id="<?= $post->id ?>" class="btn warning" id="edit">Modifier</button>
                    <button data-id="<?= $post->id; ?>" type="submit" class="btn danger" id="delete">Supprimer</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>