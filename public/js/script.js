document.addEventListener('DOMContentLoaded', function() {
    var logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('show2faBtn');
        const details = document.getElementById('twofa-details');
        if (btn && details) {
            btn.addEventListener('click', function () {
                details.classList.toggle('d-none');
            });
        }
    });
