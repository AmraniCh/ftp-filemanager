<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $renderer->render('includes/head.php', [
                'title' => 'A flexible FTP web application!',
        ]) ?>
    </head>
    <body>
        <h1>Homepage!</h1>

        <?= $renderer->render('includes/scripts.html') ?>
    </body>
</html>