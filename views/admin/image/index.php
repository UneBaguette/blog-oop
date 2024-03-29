<?php if ((bool)filter_var(($_GET['error'] ?? false), FILTER_VALIDATE_BOOLEAN)): ?>
    <div class="msg error">L'image n'a pas pu être envoyé</div>
<?php endif; ?>

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
        <?php foreach($params['images'] as $img): ?>
            <tr>
                <th scope="row" class="id"><?= $img->id; ?></th>
                <td id="text" data-text="<?= $img->name ?>"><?= $img->name; ?></td>
                <td id="text" data-text="<?= $img->alt ?>"><?= ($img->alt ?? "") ?></td>
                <td id="text" data-text="<?= $img->filename ?>"><?= file_exists($img->getfullpath() . $img->filename) ? $img->filename : '<span style="text-decoration: line-through;">'. trim($img->filename) .'</span>'. '<span style="color: var(--danger); font-weight: bold; margin: 0 5px;">NOT_FOUND</span>' ?></td>
                <td class="actions">
                    <a href="<?= HREF_ROOT ?>admin/images/edit/<?= $img->id ?>" data-id="<?= $img->id ?>" class="btn warning" id="edit">Modifier</a>
                    <button data-id="<?= $img->id; ?>" type="submit" class="btn danger" id="delete">Supprimer</button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>