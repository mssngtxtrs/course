<header>
    <div class="container">
        <a href="../" class="logo">
        <img src="../../media/placeholders/square-placeholder.svg" alt="<?php echo $website_name; ?>">
            <!-- <img src="" alt="Логотип"> -->
        </a>
        <nav class="header-nav">
            <a class="header-nav-link" href="../../about">О нас</a>
            <a class="header-nav-link" href="../../hostings">Хостинги</a>
            <a class='button urgent account' href='../../account'><?php /* "Заглушка" */ if ($auth->getName()) { echo $auth->getName(); } else { echo "Авторизация"; } ?></a>
        </nav>
    </div>
</header>

<script src="media/js/header.js"></script>
