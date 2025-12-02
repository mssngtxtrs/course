function checkScroll(direction) {
    switch (direction) {
        case "left":
            sliderPosition -= sliderWidth;
            break;
        case "right":
            sliderPosition += sliderWidth;
            break;
    }

    prevButton.disabled = false;
    nextButton.disabled = false;

    if (sliderPosition <= 0) {
        prevButton.disabled = true;
    }

    if (sliderPosition + sliderWidth >= sliderScrollEnd) {
        nextButton.disabled = true;
    }
}

function buildSlider() {
    fetch("/api/hostings?method=slider")
        .then(response => {
            if (!response) throw new Error("No response from server");
            return response.text();
        })
        .then(html => {
            slider.innerHTML = html;
        })
        .then(() => {
            sliderScroll = slider.scrollLeft;
            sliderWidth = slider.clientWidth;
            sliderScrollEnd = slider.scrollWidth;
        })
        .then(() => {
            checkScroll("still");
        })
        .catch(err => {
            console.error('Failed getting slider content: ', err);
            slider.innerHTML = "Error getting slider content";
        });
}





const slider = document.querySelector('.hostings-slider');
const prevButton = document.querySelector('.hostings-slider-controls .prev-button');
const nextButton = document.querySelector('.hostings-slider-controls .next-button');

let sliderScroll = slider.scrollLeft;
let sliderWidth = slider.clientWidth;
let sliderScrollEnd = slider.scrollWidth;
let sliderPosition = sliderScroll;


buildSlider();


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

