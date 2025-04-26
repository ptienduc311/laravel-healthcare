$(document).on("click", ".toggle-password", function () {
    const $input = $(this).siblings("input.password-input");
    const $icon = $(this).find("img");

    if ($input.attr("type") === "password") {
        $input.attr("type", "text");
        $icon.attr("src", eyeShow);
    } else {
        $input.attr("type", "password");
        $icon.attr("src", eyeHide);
    }
});
