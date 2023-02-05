<h1>Administration des tags</h1>

<?php

// TODO: fix query test

// $db = new Database\DBConnection(DB_NAME, DB_HOST, DB_USER, DB_PWD);
// $test = new \App\models\Tag($db);
// $test->resetAI()

?>

<a href="<?= HREF_ROOT ?>admin/tags/create" class="btn btn-success my-3">Créer un nouveau tag</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['tags'] as $tag) : ?>
            <tr>
                <th scope="row"><?= $tag->id; ?></th>
                <td><?= $tag->name; ?></td>
                <td>
                    <a href="<?= HREF_ROOT ?>admin/tags/edit/<?= $tag->id ?>" class="btn btn-warning">Modifier</a>
                    <form action="<?= HREF_ROOT ?>admin/tags/delete/<?= $tag->id ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>