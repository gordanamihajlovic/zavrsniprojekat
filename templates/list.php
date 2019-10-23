<?php
/**
 * Templejt za prikaz niza recepata
 *
 * @var array $recipes
 */
?>

<?php if (!empty($recipes)): ?>
    <div class="row">
        <?php foreach ($recipes as $recipe): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <?php
                    if (!empty($recipe['image'])) {
                        $imageSrc = $recipe['image'];
                    } else {
                        $imageSrc = '/images/default_recipe.jpg';
                    }
                ?>
                <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="<?php echo $recipe['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $recipe['name']; ?></h5>
                    <p class="card-text"><?php echo substr($recipe['description'], 0, 80); ?></p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <a href="/recipe/read/<?php echo $recipe['id']; ?>">Pregledaj recept</a>
                    </small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Nema recepata</p>
<?php endif; ?>
