<h1>Administration des tags</h1>

<?php if ((bool)filter_var(($_GET['error'] ?? false), FILTER_VALIDATE_BOOLEAN)): ?>
    <div class="msg error">No working, no cookie for you</div>
<?php endif; ?>

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
                    <a href="<?= HREF_ROOT ?>admin/tags/edit/<?= $tag->id ?>" data-id="<?= $tag->id ?>" class="btn warning" id="edit">Modifier</a>
                    <button data-id="<?= $tag->id; ?>" type="submit" class="btn danger" id="delete">Supprimer</button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>