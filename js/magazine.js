// Navigation Object
var nav = {};
// Matches pathname to element id
nav.idMap = {
    'login.php': '#login',
    'stats.php': '#stats',
    'userlist.php': '#user_list',
    'accesslog.php': '#access_log',
    'weblog.php': '#web_log',
    '': '#home'
}
nav.setActive = function() {
    // Get the current path and set the navbar item to active
    var currentPath = document.location.pathname.replace('/', '');
    var e = $(nav.idMap[currentPath]);
    var lastActive = $('nav .active');

    // Remove the active class from all items in the navbar
    for (var i = 0; i < lastActive.length; i++) {
        $(lastActive[i]).removeClass('active');
    }

    // Add the active class to the item corresponding to the current page
    e.addClass('active');
}

var dataTables = {};
dataTables.user_render = function(uid_idx) {
    return function(data, type, full, meta) {
        return '<a href="/edit_user.php?uid=' + full[uid_idx] + '">' + data + '</a>';
    };
}

dataTables.init = function () {
    // Initialize userlist datatable if it exists
    var userlist = $('#userlist');
    if (userlist.length > 0) {
        // Initialize DataTable
        userlist.DataTable({
            order: [[0, 'asc']],
            autoWidth: false,
            columnDefs: [{
                targets: 'user',
                render: dataTables.user_render(0)
            }]
        });
    }

    // Initialize accesslog datatable if it exists
    var accesslog = $('#accesslog');
    if (accesslog.length > 0) {
        accesslog.DataTable({
            order: [[3, 'desc']],
            autoWidth: false,
            columnDefs: [
                {width: "15%", targets: 0},
                {targets: 'user', render: dataTables.user_render(0)}
            ]
        });
    }

    // Initialize weblog datatable if it exists
    var weblog = $('#weblog');
    if (weblog.length > 0) {
        weblog.DataTable({
            order: [[3, 'desc']],
            autoWidth: false,
            columnDefs: [
                {targets: 'user', render: dataTables.user_render(0)}
            ]
        });
    }
}

$(function() {
    nav.setActive();
    dataTables.init();
});
