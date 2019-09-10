$(function () {
    $(".search-button").click(function () {
        $(".search-block input").toggleClass("active").focus();
        $(this).toggleClass("animate");
        $(".input").val('');
    });
});
