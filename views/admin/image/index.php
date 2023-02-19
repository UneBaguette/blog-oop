<h1>Administration des images</h1>

<a href="<?= HREF_ROOT ?>admin/images/create" class="btn">Créer une nouvelle image</a>

<table class="table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="id">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Alt text</th>
            <th scope="col">Filename</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['images'] as $img) : ?>
            <tr>
                <th scope="row" class="id"><?= $img->id; ?></th>
                <td><?= $img->name; ?></td>
                <td><?= $img->alt; ?></td>
                <td><?= $img->filename; ?></td>
                <td class="actions">
                    <button data-id="<?= $img->id ?>" class="btn warning" id="edit" onclick="edit(event)">Modifier</button>
                    <button data-id="<?= $img->id; ?>" type="submit" class="btn danger" id="delete" onclick="del(event)">Supprimer</button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>