
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('.nav-links a');

    links.forEach(function (link) {
        link.addEventListener('click', function (event) {
            const targetId = this.getAttribute('href');

            if (targetId && targetId.startsWith('#')) {
                const target = document.querySelector(targetId);

                if (target) {
                    event.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});