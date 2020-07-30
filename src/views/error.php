<html lang="en">
    <head>
        <?= $renderer->render('includes/head.php', [
            'title' => 'Error ' . $errorCode,
        ]) ?>
    </head>
    <body>
        <div class="error-container">
            <span class="error-text">Error</span>
            <h3 class="error-code"><?= $errorCode ?></h3>
        </div>
        <?= $renderer->render('includes/scripts.html') ?>
    </body>
</html>