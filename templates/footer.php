<footer>
    <div class="container">
        <div class="column">
            <a href="../../" class="logo">
                <img src="../../media/placeholders/square-placeholder.svg" alt="<?php echo $website_name; ?>">
            </a>
        </div>
        <div class="column">
            <nav class="footer-nav">
                <?php if (!empty($user['name'])) { echo "<p class='account'>" . $user['name'] . "</p>"; } ?>
                <a href="../../account" class="footer-nav-link">Личный кабинет</a>
                <a href="../../hostings" class="footer-nav-link">Хостинги</a>
                <a href="../../about" class="footer-nav-link">О нас</a>
            </nav>
        </div>
    </div>
</footer>
