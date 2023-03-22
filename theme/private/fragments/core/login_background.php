<?php
/**
 * @var rex_fragment $this
 * @psalm-scope-this rex_fragment
 */
?>

<picture class="rex-background">
    <source
        srcset="
            <?= theme_url::base('public/assets/backend/background-202303121611-2400.avif') ?> 2400w,
            <?= theme_url::base('public/assets/backend/background-202303121611-3600.avif') ?> 3600w"
        sizes="100vw"
        type="image/avif"
    />
    <img
        alt=""
        src="<?= theme_url::base('public/assets/backend/background-202303121611-2400.jpg') ?>"
        srcset="
            <?= theme_url::base('public/assets/backend/background-202303121611-2400.jpg') ?> 2400w,
            <?= theme_url::base('public/assets/backend/background-202303121611-3600.jpg') ?> 3600w"
        sizes="100vw"
    />
</picture>

<style>
    #rex-page-login {
        background-color: #4c1d95;
    }

    #rex-page-login .btn-primary {
        background-color: #5b21b6;
        border-color: rgba(0, 0, 0, 0.5);
    }
    
    #rex-page-login .btn-primary:hover,
    #rex-page-login .btn-primary:focus {
        background-color: #7c3aed;
    }

    #rex-page-login .rex-global-footer {
        mix-blend-mode: difference;
    }

    #rex-page-login .panel-default {
        background-color: rgb(0, 0, 0, .375);
    }
    
    @supports (mix-blend-mode: plus-lighter) {
        #rex-page-login .rex-global-footer {
            mix-blend-mode: plus-lighter;
        }
    }
</style>

<script>
    var picture = document.querySelector('.rex-background');
    
    picture.classList.add('rex-background--process');
    
    picture.querySelector('img').onload = function() {
        picture.classList.add('rex-background--ready');
    }
</script>

<footer class="rex-global-footer">
    <nav class="rex-nav-footer">
        <ul class="list-inline">
            <li><a href="https://www.dischdev.com" target="_blank" rel="noreferrer noopener">dischdev.com</a></li>
            <li><a href="https://www.yakamara.de" target="_blank" rel="noreferrer noopener">yakamara.de</a></li>
            <li><a href="https://www.redaxo.org" target="_blank" rel="noreferrer noopener">redaxo.org</a></li>
        </ul>
    </nav>
</footer>
