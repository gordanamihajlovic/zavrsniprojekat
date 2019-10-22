<?php
/**
 * Templejt za glavnu navigaciju
 *
 * @var array $categories
 */
?>
<div class="container">
    <div class="row">
    <nav class="navbar navbar-expand-lg text-white bg-info w-100" id="main-navigation">
        <button class="btn btn-link navbar-toggler d-md-none p-0" type="button"
                data-toggle="collapse" data-target="#navigationContainer" aria-controls="navigationContainer" aria-expanded="true"
                aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img" focusable="false">
                <title>Meni</title>
                <path stroke="currentColor" stroke-miterlimit="10" stroke-width="3" d="M4 7h22M4 15h22M4 23h22"></path>
            </svg>
        </button>

        <div class="collapse navbar-collapse" id="navigationContainer">
            <!-- glavna navigacija - pregled recepata po kategorijama -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <?php foreach ($categories as $category) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/recipe/list/<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <!-- dodatna navigacija - unos novog recepta -->
            <div class="my-0">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/recipe/form">Dodaj recept</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    </div>
</div>

