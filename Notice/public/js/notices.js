window.onload = function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#saveandnotsave').hide();
    $('#saveandnotsavefile').hide();

    $('#image').on('click', function(e) {
        e.preventDefault();
        $('#add_image').modal("show");
    })

    $('#attachment').on('click', function(e) {
        e.preventDefault();
        $('#add_file').modal("show");
    })

    $('#img_input').on('change', function() {
        if ($('#img_input').val() != '') {
            $('#uploadFormImg').removeAttr("disabled");
        }
    })

    $("#add_image_form").on('submit', function(e) {
        e.preventDefault();
        var data = new FormData();
        data.append('img_input', $('#img_input').prop('files')[0]);

        $('#saveandnotsave').show();
        $.ajax({
            type: 'POST',
            url: '/notices/views/upload_form_img',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var img_id = JSON.parse(response);

                $('#saveandnotsave').show();
                $('#upload_local').empty();
                $('#upload_local').val(img_id.img);

                if ($('#img').val() == '') {
                    $('#img').val(img_id.id);
                } else {
                    var image_ids = $('#img').val();
                    $('#img').val(image_ids + ',' + img_id.id);
                }

                $('#add_image').modal('hide');
                $('#img_input').empty();
                $('#uploadFormImg').prop('disabled', true);

            }
        });
    });

    $('#file').on('change', function() {
        if ($('#file').val() != '') {
            $('#uploadFormFile').removeAttr("disabled");
        }
    })

    $('#buttonFile').on('click', function() {
        $('#file').empty();
        $('#uploadFormFile').prop('disabled', true);
    })

    //submit file form
    $("#add_file_form").on('submit', function(e) {
        e.preventDefault();
        var data = new FormData();
        data.append('file', $('#file').prop('files')[0]);

        $('#saveandnotsavefile').show();
        $.ajax({
            type: 'POST',
            url: '/notices/views/upload_form_file',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var file_id = JSON.parse(response);

                $('#saveandnotsavefile').show();
                $('#upload_local_file').empty();
                $('#upload_local_file').val(file_id.file);
                if ($('#attach').val() == '') {
                    $('#attach').val(file_id.id);
                } else {
                    var file_ids = $('#attach').val();
                    $('#attach').val(file_ids + ',' + file_id.id);
                }

                $('#add_file').modal('hide');
                $('#file').empty();
                $('#uploadFormFile').prop('disabled', true);
            }
        });
    });

    $('#closemodal').on('click', function() {
        $('#add_image').modal('hide');
    })

    // saveimage + markdawn 2
    $('#image_save').on('click', function(e) {
        e.preventDefault();
        var text = $('#text').val();
        var x = selectText(text);

        var upload_local = $('#upload_local').val();
        var res = "![](/images/" +
            upload_local +
            ")";
        var formatted = text.substr(0, x.start) + ' ' + res + text.substr(x.end, x.len);
        $('#text').val(formatted);
        $('#text_formated').empty();

        $.ajax({
            type: 'post',
            url: '/notices/views/text_formated',
            data: {
                'text': formatted
            },
            success: function(response) {
                $('#text_formated').append(response);
                $('#upload_local').empty();
                $('#saveandnotsave').hide();
            }
        })

    })

    //don't save
    $('#not_save').on('click', function(e) {
        e.preventDefault();
        var upload_local = $('#upload_local').val();
        $.ajax({
            type: 'post',
            url: '/notices/views/not_save_image',
            data: {
                'upload_local': upload_local
            },
            success: function(response) {
                $('#upload_local').empty();
                $('#saveandnotsave').hide();

                var img = $('#img').val();
                var res = img.split(",");
                var result = res.pop();
                $('#img').val(res);

            }
        })

    })

    //savefale + markdawn 2
    $('#file_save').on('click', function(e) {
        e.preventDefault();
        var text = $('#text').val();
        var x = selectText(text);

        var upload_local_file = $('#upload_local_file').val();
        var res = "[" +
            upload_local_file +
            "](/files/" +
            upload_local_file +
            "/)";
        var formatted = text.substr(0, x.start) + ' ' + res + text.substr(x.end, x.len);
        $('#text').val(formatted);
        $('#text_formated').empty();

        $.ajax({
            type: 'post',
            url: '/notices/views/text_formated',
            data: {
                'text': formatted
            },
            success: function(response) {
                $('#text_formated').append(response);
                $('#upload_local_file').empty();
                $('#saveandnotsavefile').hide();
            }
        })
    })

    //don't save file
    $('#file_not_save').on('click', function(e) {
        e.preventDefault();
        var upload_local_file = $('#upload_local_file').val();
        $.ajax({
            type: 'post',
            url: '/notices/views/not_save_file',
            data: {
                'upload_local_file': upload_local_file
            },
            success: function(response) {
                $('#upload_local_file').empty();
                $('#saveandnotsavefile').hide();

                var file = $('#attach').val();
                var res = file.split(",");
                var result = res.pop();
                $('#attach').val(res);
            }
        })

    })

    //heading
    $('#heading').on('change', function(e) {
        e.preventDefault();
        var text = $('#text').val();
        var heading = $('#heading').val();
        var x = selectText(text);
        var sel = text.substr(x.start, x.numchar);

        if (heading == 1) {
            var heading = "#";
        }
        if (heading == 2) {
            var heading = "##";
        }
        if (heading == 3) {
            var heading = "###";
        }
        if (heading == 4) {
            var heading = "####";
        }
        if (heading == 5) {
            var heading = "#####";
        }

        var res = heading.concat(sel);
        var formatted = text.substr(0, x.start) + res + text.substr(x.end, x.len);
        $('#text').val(formatted);
        $('#text_formated').empty();

        $.ajax({
            type: 'post',
            url: '/notices/views/text_formated',
            data: {
                'text': formatted
            },
            success: function(response) {
                $('#text_formated').append(response);
                $('#heading').val('');
            }
        })
    })


    // })

    $('#text').on('keypress', function(e) {
        if (e.which == 13 || e.keyCode == 13) {
            e.preventDefault();

            var formatted = this.value.substring(0, this.selectionStart) +
                "\n" + "\n" +
                this.value.substring(this.selectionEnd, this.value.length);
            $('#text').val(formatted);
            $.ajax({
                type: 'post',
                url: '/text_formated',
                data: {
                    'text': formatted
                },
                success: function(response) {
                    $('#text_formated').empty();
                    $('#text_formated').append(response);
                }
            })
        }
    })
}

function selectText(text) {
    var len = text.length;
    var start = $('#text').prop('selectionStart');
    var end = $('#text').prop('selectionEnd');
    var numchar = end - start;
    return {
        len,
        start,
        end,
        numchar
    };
}


function clickElement(name) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var text = $('#text').val();
    var x = selectText(text);
    var sel = text.substr(x.start, x.numchar);

    switch (name) {
        case "bold":
            var res = "**" + sel + "**";
            break;
        case "italic":
            var res = "*" + sel + "*";
            break;
        case "link":
            var res = "[" + sel + "](//" + sel + "/)";
            break;
        case "code":
            var res = "`" + sel + "`";
            break;
        case "list":
            var res = "* " + sel;
            break;
        default:
            // code block
    }

    var formatted = text.substr(0, x.start) + res + text.substr(x.end, x.len);
    $('#text').val(formatted);
    $('#text_formated').empty();
    $.ajax({
        type: 'post',
        url: '/notices/views/text_formated',
        data: {
            'text': formatted
        },
        success: function(response) {
            $('#text_formated').empty();
            $('#text_formated').append(response);
        }
    })
}