// Navigation Object
var nav = {};

// Matches pathname to element id
nav.idMap = {
    'login.php': '#login',
    '': '#home'
}

nav.setActive = function() {
    // Get the current path and set the navbar item to active
    var currentPath = document.location.pathname.replace('/', '');
    var e = $(nav.idMap[currentPath]);
    var lastActive = $.find('nav .active');

    // Remove the active class from all items in the navbar
    for (var i = 0; i < lastActive.length; i++) {
        $(lastActive[i]).removeClass('active');
    }

    // Add the active class to the item corresponding to the current page
    e.addClass('active');
}

$(function() {
    nav.setActive();
});
