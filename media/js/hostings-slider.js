const slider = document.querySelector('.hostings-slider');
const prevButton = document.querySelector('.hostings-slider-controls .prev-button');
const nextButton = document.querySelector('.hostings-slider-controls .next-button');

const sliderScroll = slider.scrollLeft;
const sliderWidth = slider.clientWidth;
const sliderScrollEnd = slider.scrollWidth;

let sliderPosition = sliderScroll;

function checkScroll(direction) {
    switch (direction) {
        case "left":
            sliderPosition -= sliderWidth;
            break;
        case "right":
            sliderPosition += sliderWidth;
            break;
    }

    // console.log("sliderPosition: " + sliderPosition + "\n( + " + sliderWidth + " = " + (sliderPosition + sliderWidth) + " )\n( - " + sliderWidth + " = " + (sliderPosition - sliderWidth) + " )" + "\nsliderScroll: " + sliderScroll + "\nsliderWidth: " + sliderWidth + "\nsliderScrollEnd: " + sliderScrollEnd);

    prevButton.disabled = false;
    nextButton.disabled = false;

    if (sliderPosition <= 0) {
        prevButton.disabled = true;
    }

    if (sliderPosition + sliderWidth >= sliderScrollEnd) {
        nextButton.disabled = true;
    }
}

prevButton.addEventListener('click', () => {
    slider.scrollBy({
        left: -sliderWidth,
    });
    checkScroll("left");
});

nextButton.addEventListener('click', () => {
    slider.scrollBy({
        left: sliderWidth,
    });
    checkScroll("right");
});

checkScroll("still");
