<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $renderer->render('includes/head.php', [
            'title' => 'Login!',
        ]) ?>
    </head>
    <body>
        <div class="login-wrapper">
            <header class="header">
                <div class="brand">
                    <h3 class="name uppercase">ftp app</h3>
                </div>
            </header>
            <form class="login-form">
                <div class="input-area">
                    <input type="text" placeholder="Host">
                </div>
                <div class="input-area">
                    <input type="text" placeholder="Username">
                </div>
                <div class="input-area">
                    <input type="text" placeholder="Password">
                </div>
                <div class="input-area">
                    <input type="text" placeholder="Port" value="21">
                </div>
                <label class="checkbox">
                    <input type="checkbox">
                    <span class="checkbox-text">use SSL connection (If available)</span>
                </label>
                <label class="checkbox">
                    <input type="checkbox">
                    <span class="checkbox-text">use passive connection</span>
                </label>
                <div class="form-actions">
                    <input type="submit" class="btn-primary" value="login">
                </div>
            </form>
            <svg class="shape-right" width="324" height="374" viewBox="0 0 324 374" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M122.849 189.266C122.849 93.0643 324 0 324 0V374H0C0 374 122.849 285.467 122.849 189.266Z"
                      fill="#FFFFFF"/>
            </svg>
            <svg class="shape-left" width="149" height="265" viewBox="0 0 149 265" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M83.3926 124.404C31.618 61.6095 0 0 0 0V265H149C149 265 135.167 187.198 83.3926 124.404Z"
                      fill="#FFFFFF"/>
            </svg>
            <a href="/" class="shape-arrow">
                <svg width="75" height="47" viewBox="0 0 75 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.8846 23.7197L33.5455 1.34388C35.5326 -0.0604612 38.2769 1.36056 38.2769 3.7938V14.6047H72C73.6569 14.6047 75 15.9478 75 17.6047V28.2093C75 29.8662 73.6569 31.2093 72 31.2093H38.2769V43.8839C38.2769 46.1753 35.8118 47.6208 33.8121 46.5019L2.15124 28.7877C0.22576 27.7104 0.0827997 24.9931 1.8846 23.7197Z" fill="#EE3C5C"/>
                </svg>
            </a>
        </div>
        <?= $renderer->render('includes/scripts.html') ?>
    </body>
</html>