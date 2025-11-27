const buttons = document.querySelectorAll('.auth-switcher button');
const forms = document.querySelectorAll('.forms form');

buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.target;

        forms.forEach(f => f.style.display = 'none');
        document.getElementById(id).style.display = 'flex';

        buttons.forEach(b => b.classList.remove('opened'));
        btn.classList.add('opened');
    });
});

forms[0].style.display = 'flex';
buttons[0].classList.add('opened');
