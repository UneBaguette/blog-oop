<h1>Administration des images</h1>

<a href="<?= HREF_ROOT ?>admin/images/create" class="btn success">Créer une nouvelle image</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Alt text</th>
            <th scope="col">Filename</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['images'] as $img) : ?>
            <tr>
                <th scope="row"><?= $img->id; ?></th>
                <td><?= $img->name; ?></td>
                <td><?= $img->alt; ?></td>
                <td><?= $img->filename; ?></td>
                <td>
                    <a href="<?= HREF_ROOT ?>admin/images/edit/<?= $img->id ?>" class="btn warning">Modifier</a>
                    <form action="<?= HREF_ROOT ?>admin/images/delete/<?= $img->id ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>