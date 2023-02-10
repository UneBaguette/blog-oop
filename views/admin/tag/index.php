<h1>Administration des tags</h1>

<a href="<?= HREF_ROOT ?>admin/tags/create" class="btn">Créer un nouveau tag</a>

<table class="table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="id">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['tags'] as $tag) : ?>
            <tr>
                <th scope="row" class="id"><?= $tag->id; ?></th>
                <td><?= $tag->name; ?></td>
                <td class="actions">
                    <a href="<?= HREF_ROOT ?>admin/tags/edit/<?= $tag->id ?>" class="btn warning">Modifier</a>
                    <form action="<?= HREF_ROOT ?>admin/tags/delete/<?= $tag->id ?>" method="POST">
                        <button type="submit" class="btn danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>