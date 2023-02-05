<h1>Administration des articles</h1>

<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">Vous êtes connecté ! (Connecté en tant que "<?= $_SESSION['connectedas'] ?>")</div>
    <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">Vous êtes enregistré avec succès !</div>
    <?php endif; ?>
<?php endif; ?>

<a href="<?= HREF_ROOT ?>admin/posts/create" class="btn btn-success my-3">Créer un nouvel article</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Titre</th>
            <th scope="col">Publié le</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['posts'] as $post) : ?>
            <tr>
                <th scope="row"><?= $post->id; ?></th>
                <td><?= $post->title; ?></td>
                <td><?= $post->getCreatedAt(); ?></td>
                <td>
                    <a href="<?= HREF_ROOT ?>admin/posts/edit/<?= $post->id ?>?onpage=false" class="btn btn-warning">Modifier</a>
                    <form action="<?= HREF_ROOT ?>admin/posts/delete/<?= $post->id ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
