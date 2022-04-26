//Set Active Class in MenuBar
//noinspection JSUnresolvedVariable
// $("#menubar").find("a[href='" + requestUrl + "']").addClass('active');
//
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on("click", ".item-delete", function () {

    var $button = $(this);
    var url_id = $button.attr("id");

    $row = $(this).closest("tr");
    bootbox.confirm("Are you sure you want to delete this item?", function (response) {
        // alert(url_id);
        if (response)
            $.ajax({
                "type": "GET",
                "url": $button.data("url"),
                "data": {
                    _method: "delete"

                },
                "success": function (data) {
                    $row.addClass("danger").fadeOut();
                },
                "error": function (err) {
                    bootbox.alert("Delete failed!");
                }
            });

    });
});

$(document).ready(function () {
    $(".search").on("keyup", function () {
        var $search = $(this);
        $(".menu").each(function () {
            var $menu = $(this);
            $(this).find(".title").each(function () {
                if (~$(this).html().toLowerCase().indexOf($search.val().toLowerCase())) {
                    $menu.show();
                    return false;
                } else {
                    $menu.hide();
                }
            });
        });
    });

    if ($.isFunction($.fn.dropify)) {
        $(".dropify").dropify();
    }
});


$(document).on("click", ".removeThis", function (e) {
    e.preventDefault();
    var $button = $(this);
    $row = $(this).closest("#parentId");
    bootbox.confirm("Are you sure you want to delete this item?", function (response) {
        if (response)
            $.ajax({
                "type": "POST",
                "url": $button.data("url"),
                "data": {
                    'item_name': $button.data("item-name"),
                    'ref_id': $button.data("ref-id")
                },
                "success": function (data) {
                    $row.fadeOut('1000').remove();
                },
                "error": function (err) {
                    bootbox.alert("Delete failed!");
                }
            });

    });
});
