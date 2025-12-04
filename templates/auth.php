<section id="auth">
    <div class="container">
        <div class="auth-switcher">
            <div class="button-wrap">
                <button data-target="login"><?= $dictionary->getDictionaryString("log-in-btn", "auth") ?></button>
            </div>
            <div class="button-wrap">
                <button data-target="reg"><?= $dictionary->getDictionaryString("register-btn", "auth") ?></button>
            </div>
        </div>

        <div class="forms">
            <form action="api/auth?action=log-in" id="login" method="post">
                <div class="row">
                    <div class="input"><label for="login"><?= $dictionary->getDictionaryString("login", "auth") ?></label><input type="text" name="login" required></div>
                </div>
                <div class="row">
                    <div class="input"><label for="password"><?= $dictionary->getDictionaryString("password", "auth") ?></label><input type="password" name="password" required></div>
                </div>
                <input type="submit" class="button urgent" value="<?= $dictionary->getDictionaryString("log-in", "auth") ?>">
            </form>

            <form action="api/auth?action=register" id="reg" method="post">
                <div class="row">
                    <div class="input"><label for="name"><?= $dictionary->getDictionaryString("name", "auth") ?></label><input type="text" name="name" required></div>
                    <div class="input"><label for="surname"><?= $dictionary->getDictionaryString("surname", "auth") ?></label><input type="text" name="surname" required></div>
                </div>
                <div class="row">
                    <div class="input"><label for="login"><?= $dictionary->getDictionaryString("login", "auth") ?></label><input type="text" name="login" required></div>
                </div>
                <div class="row">
                    <div class="input"><label for="email"><?= $dictionary->getDictionaryString("email", "auth") ?></label><input type="email" name="email" required></div>
                </div>
                <div class="row">
                    <div class="input"><label for="password"><?= $dictionary->getDictionaryString("password", "auth") ?></label><input type="password" name="password" required></div>
                </div>
                <div class="row">
                    <div class="input"><label for="password-confirm"><?= $dictionary->getDictionaryString("password-confirm", "auth") ?></label><input type="password" name="password-confirm" required></div>
                </div>
                <div class="row">
                    <div class="input"><input type="checkbox" name="consent" required><label for="consent"><?= $dictionary->getDictionaryString("consent", "auth") ?></label></div>
                </div>
                <input class="button urgent" type="submit" value="<?= $dictionary->getDictionaryString("register", "auth") ?>">
            </form>
        </div>
    </div>
</section>

<script src="media/js/auth.js"></script>
