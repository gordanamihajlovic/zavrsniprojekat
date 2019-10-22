<?php
/**
 * Templejt za prikaz recepta
 *
 * @var array  $recipe
 * @var string $categoryName
 */
?>

<p class="text-left font-italic">Poslednja izmena <?php echo date("d.m.Y", strtotime($recipe['date_updated'])); ?>, iz kategorije "<?php echo $categoryName; ?>"</p>

<div class="card">
    <?php if (!empty($recipe['image'])): ?>
    <img class="card-img-top" src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['name']; ?>">
    <?php endif; ?>
    <div class="card-body">
        <?php echo nl2br($recipe['description']); ?>
    </div>
    <div class="card-body">
        <a href="/recipe/form/<?php echo $recipe['id']; ?>" class="card-link">Izmeni recept</a>
        <a href="/recipe/delete/<?php echo $recipe['id']; ?>" class="card-link">Obriši recept</a>
    </div>
</div>
