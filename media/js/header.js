const header = document.querySelector('header');

self.addEventListener('scroll', () => {
        const triggerPoint = globalThis.innerHeight - (globalThis.innerHeight * 0.9);

    function getPageOffset(element) {
        let topOffset = element.getBoundingClientRect().top;

        while (element != document.documentElement) {
            element = element.parentElement;
            topOffset += element.scrollTop;
        }

        return topOffset;
    };

    const pos = getPageOffset(header);

    if (pos > triggerPoint) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
