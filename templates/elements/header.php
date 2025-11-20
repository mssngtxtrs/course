<header>
    <div class="container">
        <a href="../" class="logo">
        <img src="../../media/placeholders/square-placeholder.svg" alt="<?php echo $website_name; ?>">
            <!-- <img src="" alt="Логотип"> -->
        </a>
        <nav class="header-nav">
            <a class="header-nav-link" href="../../about">О нас</a>
            <a class="header-nav-link" href="../../hostings">Хостинги</a>
<?php
if (isset($user['name'])) {
    echo "<a class='button urgent account' href='../../account'>" . $user['name'] . "</a>";
} else {
    echo "<a class='button urgent' href='../../login'>Войти</a><a class='button' href='../../auth'>Регистрация</a>";
}
?>
        </nav>
    </div>
</header>
