$(document).ready(function () {
    "use strict";

    // Binding Simple Scrollbar For Sidebar Menu
    var el = document.querySelectorAll(".simple-scroll");
    for (let i = 0; i < el.length; i++) {
        SimpleScrollbar.initEl(el[i]);
    }
});

window.onload = function() {
    $(".preload").slideUp();
}
