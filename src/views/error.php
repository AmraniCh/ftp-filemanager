<html lang="en">
    <head>
        <?= $renderer->render('includes/head.php', [
            'title' => 'Error ' . $errorCode,
        ]) ?>
    </head>
    <body>
        <h1>Error page! <?= $errorCode ?></h1>

        <?= $renderer->render('includes/scripts.html') ?>
    </body>
</html>