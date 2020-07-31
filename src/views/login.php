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
            <form id="loginForm" class="login-form">
                <div class="input-area">
                    <input type="text" name="host" placeholder="Host">
                </div>
                <div class="input-area">
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="input-area">
                    <input type="text" name="password" placeholder="Password">
                </div>
                <div class="input-area">
                    <input type="text" name="port" placeholder="Port" value="21">
                </div>
                <label class="checkbox" for="useSsl">
                    <input type="checkbox" id="useSsl" name="useSsl">
                    <span class="checkbox-text">use SSL connection (If available)</span>
                </label>
                <label class="checkbox" for="usePassive">
                    <input type="checkbox" id="usePassive" name="usePassive">
                    <span class="checkbox-text">use passive connection</span>
                </label>
                <div class="form-actions">
                    <input type="submit" id="loginBtn" class="btn-primary" value="login">
                </div>
            </form>
            <a target="_blank" href="https://github.com/ELAMRANI744/ftp-filemanager">
                <button type="button" class="btn-primary github-btn">
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5014 1.07431e-06C5.59435 -0.00286787 0 5.74076 0 12.8299C0 18.4359 3.49961 23.2012 8.37337 24.9512C9.02972 25.1205 8.92917 24.6414 8.92917 24.3143V22.0909C5.13909 22.5471 4.98548 19.9707 4.73131 19.5404C4.21741 18.6395 3.00246 18.41 3.36555 17.9797C4.22858 17.5235 5.10837 18.0944 6.12781 19.6408C6.86515 20.7626 8.30354 20.5732 9.03251 20.3867C9.19171 19.7125 9.53245 19.1101 10.0017 18.6424C6.07474 17.9194 4.43805 15.4579 4.43805 12.5316C4.43805 11.1114 4.89331 9.80606 5.78706 8.75316C5.21729 7.01744 5.84013 5.53133 5.92392 5.31042C7.54664 5.16124 9.2336 6.5039 9.36488 6.61005C10.2866 6.35472 11.3395 6.21988 12.5182 6.21988C13.7024 6.21988 14.7581 6.36046 15.6882 6.61866C16.0038 6.37193 17.5679 5.21861 19.0761 5.35919C19.1571 5.5801 19.7659 7.03179 19.2297 8.74455C20.1346 9.80032 20.5955 11.1172 20.5955 12.5402C20.5955 15.4722 18.9476 17.9367 15.0095 18.6482C15.3468 18.9889 15.6146 19.3953 15.7973 19.8435C15.98 20.2918 16.074 20.7729 16.0736 21.2589V24.4865C16.096 24.7447 16.0736 25 16.4926 25C21.4389 23.2872 25 18.4875 25 12.8328C25 5.74076 19.4029 1.07431e-06 12.5014 1.07431e-06V1.07431e-06Z"
                              fill="white"/>
                    </svg>
                </button>
            </a>
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
                    <path d="M1.8846 23.7197L33.5455 1.34388C35.5326 -0.0604612 38.2769 1.36056 38.2769 3.7938V14.6047H72C73.6569 14.6047 75 15.9478 75 17.6047V28.2093C75 29.8662 73.6569 31.2093 72 31.2093H38.2769V43.8839C38.2769 46.1753 35.8118 47.6208 33.8121 46.5019L2.15124 28.7877C0.22576 27.7104 0.0827997 24.9931 1.8846 23.7197Z"
                          fill="#EE3C5C"/>
                </svg>
            </a>
        </div>
        <?= $renderer->render('includes/scripts.html') ?>
    </body>
</html>