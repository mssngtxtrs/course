<header>
    <div class="container">
        <a href="../" class="logo">
        <img src="../../media/placeholders/square-placeholder.svg" alt="<?= $this->website_name ?>">
            <!-- <img src="" alt="Логотип"> -->
        </a>
        <nav class="header-nav">
        <a class="header-nav-link" href="../../about"><?= $dictionary->getDictionaryString("about", "common") ?></a>
            <a class="header-nav-link" href="../../hostings"><?= $dictionary->getDictionaryString("hostings", "common") ?></a>
            <a class='button urgent account' href='../../account'><?php /* "Заглушка" */ if ($auth->getName()) {
                echo $auth->getName();
            } else {
                echo $dictionary->getDictionaryString("auth", "common");
            } ?></a>
        </nav>
    </div>
</header>

<script src="media/js/header.js"></script>
