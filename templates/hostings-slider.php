<section id="hostings-slider">
    <div class="container">
        <h1>Наши хостинги</h1>
        <div class="hostings-slider">
            <?= $hostings->returnHostings("slider") ?>
        </div>
        <div class="hostings-slider-controls">
            <button class="prev-button button"><img id="prev-button-icon" src="media/icons/prev.svg" alt="⮜"></button>
            <button class="next-button button"><img id="next-button-icon" src="media/icons/next.svg" alt="⮞"></button>
        </div>
        <script>
            const slider = document.querySelector('.hostings-slider');
            const prevButton = document.querySelector('.prev-button');
            const nextButton = document.querySelector('.next-button');

            const prevButtonIcon = document.getElementById('prev-button-icon');
            const nextButtonIcon = document.getElementById('next-button-icon');

            const max = document.getElementsByClassName('.hosting').length;
            var index = 0;

            prevButton.addEventListener('click', () => {
                slider.scrollBy({
                    left: -1024,
                });
                /* if (index === 0) { */
                /*     prevButtonIcon.style.setProperty("opacity", "0.5"); */
                /* } else { */
                /*     nextButtonIcon.style.setProperty("opacity", "1"); */
                /*     prevButtonIcon.style.setProperty("opacity", "1"); */
                /*     index += 1; */
                /* } */
            });

            nextButton.addEventListener('click', () => {
                slider.scrollBy({
                    left: 1024,
                });
                /* if (index === max) { */
                /*     nextButtonIcon.style.setProperty("opacity", "0.5"); */
                /* } else { */
                /*     prevButtonIcon.style.setProperty("opacity", "1"); */
                /*     nextButtonIcon.style.setProperty("opacity", "1"); */
                /*     index -= 1; */
                /* } */
            });
        </script>
    </div>
</section>
