document.body.addEventListener('click', function (event) {
    if (event.target.className === 'theme-switcher') {
        const target = event.target;
        const theme = target.getAttribute("data-theme");
        const switchers = document.querySelectorAll(".theme-switcher");
        [].forEach.call(switchers, function(el) {
            el.classList.remove("hidden");
        });
        target.classList.add('hidden');
        document.querySelector('html').setAttribute('class', theme);
        localStorage.setItem('theme', theme);
    }
}, false);

const activeTheme = localStorage.getItem('theme');
document.querySelector('[data-theme="'+activeTheme+'"]').classList.add('hidden');
document.querySelector('html').setAttribute('class', activeTheme);


