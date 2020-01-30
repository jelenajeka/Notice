function searchNotice() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var search_notice = $('#search_notice').val();
    var urlSplit = (window.location.href).split("?");
    var obj = {
        Title: '',
        Url: 'notices' + '?search_notice=' + search_notice
    };
    history.pushState(obj, obj.Title, obj.Url);

    $.ajax({
        type: 'get',
        url: '/notices/views/search?search_notice=' + search_notice,
        success: function(response) {
            $('#table_notices').replaceWith(response);
        },
        error: function(err) {
            console.log("error", err);
        }
    })
}

function viewNotices() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var urlSplit = (window.location.href).split("?");
    var obj = {
        Title: '',
        Url: 'notices' + '?all',
    };
    history.pushState(obj, obj.Title, obj.Url);

    $.ajax({
        type: 'get',
        url: '/notices?all',
        data: {},
        success: function(response) {
            $('#table_notices').replaceWith(response);
        },
        error: function(err) {
            console.log("error", err);
        }
    })
}

function noticesGroup(group_id, type_name) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var urlSplit = (window.location.href).split("?");
    var obj = {
        Title: '',
        Url: urlSplit[0] + '?type_name=' + type_name
    };
    history.pushState(obj, obj.Title, obj.Url);
    $.ajax({
        type: 'post',
        url: '/notices/views/notices_group?type_name=' + type_name,
        data: {
            'group_id': group_id
        },
        success: function(response) {
            $('#table_notices').replaceWith(response);
        },
        error: function(err) {
            console.log("error", err);
        }
    })
}

function deleteNotice(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'delete',
        url: '/notices/id',
        data: {
            'id': id
        },
        success: function(response) {
            if (response == "deleted") {
                location.reload();
            } else {
                console.log("not delete");
            }
        }
    });
}

function deleteType(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'delete',
        url: '/types/id',
        data: {
            'id': id
        },
        success: function(response) {
            if (response == "deleted") {
                location.reload();
            } else {
                if (response == "not") {
                    console.log(response);
                }
            }
        }
    });
}
