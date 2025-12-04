<section id="banner">
    <div class="container">
        <div class="column">
            <h1><?= $dictionary->getDictionaryString("banner", "main") ?></h1>
            <p><?= $dictionary->getdictionarystring("banner-text", "main") ?></p>
            <a class="button" href="reservation"><?= $dictionary->getdictionarystring("reservation-make", "common") ?></a>
        </div>
        <div class="column">
            <img src="../../media/placeholders/square-placeholder.svg" alt="аренда хостинга">
            <!-- <img src="" alt="аренда хостинга"> -->
        </div>
    </div>
</section>
