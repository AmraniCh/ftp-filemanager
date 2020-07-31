<html lang="en">
    <head>
        <?= $renderer->render('includes/meta.html') ?>
        <title><?= 'Error ' . $errorCode ?></title>
    </head>
    <body>
        <div class="error-container">
            <span class="error-text">Error</span>
            <h3 class="error-code"><?= $errorCode ?></h3>
        </div>
    </body>
</html>