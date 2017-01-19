// Navigation Object
var nav = {};
// Matches pathname to element id
nav.idMap = {
    'login.php': '#login',
    'stats.php': '#stats',
    'userlist.php': '#user_list',
    'accesslog.php': '#access_log',
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

// UserList Object
var userList = {};
// User list initialize function
userList.init = function() {
    var e = $('#userlist');
    if (e.length > 0) {
        // Initialize DataTable
        e.DataTable({
            order: [[0, 'asc']],
            autoWidth: false,
            columnDefs: [{
                targets: 'user',
                render: function(data, type, full, meta) {
                    return '<a href="/edit_user.php?uid=' + full[0] + '">' + data + '</a>';
                }
            }]
        });
    }
}

// AccessLog Object
var accessLog = {};
// Access log initialize function
accessLog.init = function() {
    var e = $('#accesslog');
    if (e.length > 0) {
        e.DataTable({
            order: [[3, 'desc']],
            autoWidth: false,
            columnDefs: [
                {width: "15%", targets: 0},
                {
                    targets: 'user',
                    render: function(data, type, full, meta) {
                        return '<a href="/edit_user.php?uid=' + full[0] + '">' + data + '</a>';
                    }
                }]
            });
        }
    }

    $(function() {
        nav.setActive();
        userList.init();
        accessLog.init();
    });
