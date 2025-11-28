<footer>
    <div class="container">
        <div class="column">
            <a href="../../" class="logo"><img src="../../media/placeholders/square-placeholder.svg" alt="<?php echo $website_name; ?>"></a>
            <a href="loc?lang=ru" class="language" id="ru"><?= $dictionary->getDictionaryString("locale-ru", "common") ?></a>
            <a href="loc?lang=en" class="language" id="en"><?= $dictionary->getDictionaryString("locale-en", "common") ?></a>
        </div>
        <div class="column">
            <nav class="footer-nav">
                <?php /* "Заглушка" */ if ($auth->getName()) { echo "<p class='account'>" . $auth->getName() . "</p>"; } ?>
                <a href="../../account" class="footer-nav-link"><?= $dictionary->getDictionaryString("account", "common") ?></a>
                <a href="../../hostings" class="footer-nav-link"><?= $dictionary->getDictionaryString("hostings", "common") ?></a>
                <a href="../../about" class="footer-nav-link"><?= $dictionary->getDictionaryString("about", "common") ?></a>
            </nav>
        </div>
    </div>
</footer>
