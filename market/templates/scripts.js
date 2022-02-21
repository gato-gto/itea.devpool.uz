$(document).ready(function () {
    $("a.nav-link[href]").each(function () {
        if (this.href === window.location.href) {
            $(this).addClass("active");
        }
    });
    $('.rm_btn').on('click', function (e) {
        if (!window.confirm("Вы уверены?")) {
            e.preventDefault()
        }
    })
});
