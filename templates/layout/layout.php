<?php
/**
 * @var string $content
 * @var array $categories
 */
?>
<html lang="sr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Cookbook</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat&display=swap" rel="stylesheet">
        <link href="/css/fontawesome.min.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/bootstrap-grid.min.css" rel="stylesheet">
        <link href="/css/bootstrap-reboot.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/css/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- main navigation -->
        <?php require_once "navigation.php"; ?>

        <!-- content -->
        <div class="container content">
            <div class="row">
                <div class="col-12 col-md-9 mt-3">
                    <div class="ml-3 mb-5">
                        <?php if (isset($pageTitle)): ?>
                        <h1 class="pl-0 pt-2 pb-2"><?php echo $pageTitle; ?></h1>
                        <?php endif; ?>
                        <?php echo $content; ?>
                    </div>
                </div>
                <div class="col-12 col-md-3 mt-3 bd-sidebar">
                    <!-- right sidebar -->
                    <?php require_once "sidebar.php"; ?>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="/js/bootstrap.bundle.js"></script>
        <!-- Custom JS -->
        <script src="/js/script.js"></script>
    </body>
</html>
