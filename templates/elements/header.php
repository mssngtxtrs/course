<header>
    <div class="container">
        <a href="../" class="logo">
        <img src="../../media/placeholders/square-placeholder.svg" alt="<?php echo $website_name; ?>">
            <!-- <img src="" alt="Логотип"> -->
        </a>
        <nav class="header-nav">
            <!-- <a href="../../media/placeholders/rickroll.mp4" class="header-nav-link">О нас</a> -->
            <a class="header-nav-link" href="../../about">О нас</a>
            <!-- <a href="../../media/placeholders/rickroll.mp4" class="header-nav-link">Хостинги</a> -->
            <a class="header-nav-link" href="../../hostings">Хостинги</a>
            <!-- <a href="../../media/placeholders/rickroll.mp4" class="header-nav-link">Личный кабинет</a> -->
            <a class="account" href="../../account"><?php if (isset($user['name'])) { echo $user['name']; } else { echo "Войти"; } ?></a>
        </nav>
    </div>
</header>
