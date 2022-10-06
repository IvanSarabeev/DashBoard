$(document).ready(function() {

    var count = $('#orCount').val();
    $('#insertOrCount').html(count);

    var count = $('#orCount1').val();
    $('#insertOrCount1').html(count);

    $('#show-input').click(function() {
        if ($('.inputSearch').hasClass('d-none')) {
            $('.inputSearch').removeClass('d-none');
        } else {
            $('.inputSearch').addClass('d-none');
        }

    });

    $('#fileField').change(function() {
        var file = $(this)[0].files[0].name;
        $('#imageName').html(file);
    });

    $('.inputIsNot').attr('style', 'border-bottom: solid 1px #66bb6a !important; border-radius: 0px !important;');

    if ($('#signInPhone').val() != "") {
        $('#signInPhone').attr('style', 'border-bottom: solid 1px #66bb6a !important; border-radius: 0px !important;');
    }

    jQuery(($) => {
        $('.attachment input[type="file"]')
            .on('change', (event) => {
                let el = $(event.target).closest('.attachment').find('.btn-file');

                el
                    .find('.btn-file__actions__item')
                    .css({
                        'padding': '130px'
                    });

                el
                    .find('.btn-file__preview')
                    .css({
                        'background-image': 'url(' + window.URL.createObjectURL(event.target.files[0]) + ')'
                    });
            });
    });


    var action = 'data';

    $(document).on('click', '.column_sort', function() {
        var column_name = $(this).attr("name");
        var column_id = $(this).attr("id");
        var name = $("#username").val();
        var order = $(this).data("order");
        var date = $("#dateFilter").val();
        var arrow = '';
        if (order == 'desc') {
            arrow = '<span class="ml-1"><i class="bi bi-arrow-up"></i></span>';
        } else {
            arrow = '<span class="ml-1"><i class="bi bi-arrow-down"></i></span>';
        }

        $.ajax({
            url: "filters/columnFilter.php",
            method: "POST",
            data: {
                action: action,
                date: date,
                column_name: column_name,
                name: name,
                order: order
            },
            success: function(data) {
                $("#myTable").html(data);
                console.log(data);
                $('#' + column_id + '').append(arrow);

            }
        })
    });

    $("#reloadBtn").on('click', function() {

        $.ajax({
            url: "orders/reload.php",
            method: "POST",
            data: {
                action: action,
            },
            success: function(data) {
                var actionDate = 'data';
                var date = $("#dateFilter").val();

                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        actionDate: actionDate,
                        date: date,
                    },
                    success: function(data) {
                        console.log(data);
                        $("#myTable").html(data);
                        $("#dateFilter").val(date);
                    }
                });

                var action = 'data';

                $.ajax({
                    url: "filters/stat.php",
                    type: "POST",
                    data: {
                        action: action,
                        date: date,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        $("#finishedEx").html(res.a);
                        $("#orderCount").html(res.b);

                        if (res.a != 0 && res.b != 0) {
                            if (res.a == res.b) {
                                $('#doneEx').removeClass("text-primary");
                                $('#doneEx').addClass("bg-gradient");
                                $('#doneEx').addClass("bg-success");
                                $('#doneEx').addClass("text-white");
                            } else if (res.a != res.b) {
                                $('#doneEx').addClass("text-primary");
                                $('#doneEx').removeClass("bg-gradient");
                                $('#doneEx').removeClass("bg-success");
                                $('#doneEx').removeClass("text-white");
                            }
                        }

                        $("#inProcessEx").html(res.c);
                    }
                });
            }
        })
    });

    $("#closeEd").on('click', function() {
        $('#оrderEditModal').modal('hide');
    });

    $("#closeEditModal").on('click', function() {
        $('#оrderEditModal').modal('hide');
    });

    $("#closeOrderEdit").on('click', function() {
        $('#оrderEditModal').modal('hide');
    });

    $("#username").on('keyup', function() {
        var name = $(this).val();
        var date = $("#dateFilter").val();

        $.ajax({
            url: "filters/nameFilter.php",
            type: "POST",
            data: {
                action: action,
                date: date,
                name: name
            },
            success: function(data) {
                $("#myTable").html(data);
            }
        });
    });

    $("#dateFilter").on('change', function() {
        var date = $(this).val();
        var name = $("#username").val();
        var d = new Date();

        if (d.getDate() < 10 && d.getMonth() + 1 < 10) {
            var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-0" + d.getDate();
        } else if (d.getDate() >= 10 && d.getMonth() + 1 < 10) {
            var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-" + d.getDate();
        } else if (d.getDate() < 10 && d.getMonth() + 1 >= 10) {
            var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-0" + d.getDate();
        } else if (d.getDate() >= 10 && d.getMonth() + 1 >= 10) {
            var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
        }

        if (date == strDate) {
            $(".today").html("За днес");
        } else {
            var year = date.substr(0, date.indexOf('-'));

            var n = 2;
            var a = date.split('-');
            var day = a.slice(n).join('-');

            var index = date.indexOf('-', date.indexOf('-') + 1);
            var firstChunk = date.substr(0, index);
            var index1 = firstChunk.indexOf('-');
            var month = firstChunk.substr(index1 + 1);

            var curDate = day + "." + month + "." + year;

            $(".today").html(curDate);
        }

        $.ajax({
            url: "filters/dateFilter.php",
            type: "POST",
            data: {
                action: action,
                date: date,
                name: name
            },
            success: function(data) {
                $("#myTable").html(data);
            }
        });
    });

    $("#dateFilter").change(function() {
        var date = $(this).val();

        $.ajax({
            url: "filters/stat.php",
            type: "POST",
            data: {
                action: action,
                date: date,
            },
            success: function(data) {
                var res = jQuery.parseJSON(data);
                $("#finishedEx").html(res.a);
                $("#orderCount").html(res.b);
                $("#inProcessEx").html(res.c);

                if (res.a != 0 && res.b != 0) {
                    if (res.a == res.b) {
                        $('#doneEx').removeClass("text-primary");
                        $('#doneEx').addClass("bg-gradient");
                        $('#doneEx').addClass("bg-success");
                        $('#doneEx').addClass("text-white");
                    } else if (res.a != res.b) {
                        $('#doneEx').addClass("text-primary");
                        $('#doneEx').removeClass("bg-gradient");
                        $('#doneEx').removeClass("bg-success");
                        $('#doneEx').removeClass("text-white");
                    }
                } else {
                    $('#doneEx').addClass("text-primary");
                    $('#doneEx').removeClass("bg-gradient");
                    $('#doneEx').removeClass("bg-success");
                    $('#doneEx').removeClass("text-white");
                }
            }
        });
    });


    $(".closeCancelModal").click(function() {
        $('#cancelModal').modal('hide');
        $('#оrderEditModal').modal('show');
    });

    $('#text-area').keyup(function() {

        var areaValue = $(this).val();
        var charCount = $(this).val().length;
        $("#charCount").text(charCount);

        if (charCount >= 150) {
            $(this).val(areaValue.substring(0, 150));
            $("#charCount").css({
                'color': '#FF3131'
            });
            $("#maxChar").css({
                'color': '#FF3131'
            });
        } else {
            $("#charCount").css({
                'color': 'black'
            });
            $("#maxChar").css({
                'color': 'black'
            });
        }
    });

    $(document).on('click', '.delete_team', function(e) {
        var id = $(this).val();
        alertify.confirm("Сигурни ли сте, че искате да изтриете екипа?", function(e) {
            if (e) {
                $.ajax({
                    type: "POST",
                    url: "teams/dashAction.php",
                    data: {
                        'delete_team': true,
                        'id': id
                    },
                    success: function(response) {

                        var res = jQuery.parseJSON(response);
                        if (res.status == 500) {

                            alert(res.message);
                        } else {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(res.message);

                            $('#teamTable').load(location.href + " #teamTable");
                            $('#myTable').load(location.href + " #myTable");
                            $('#userTable').load(location.href + " #userTable");
                        }
                    }
                });
            }
        }).set({ title: "Изтриване на екипа" }).set({ labels: { ok: 'Да', cancel: 'Откажи' } });
    });

    $("#endOrder").click(function() {
        var id = $("#id").val();

        alertify.confirm("Сигурни ли сте ?", function(e) {
            if (e) {
                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        action: action,
                        id: id,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        if (res.status == 200) {
                            $('#оrderEditModal').modal('hide');

                            var actionDate = 'data';
                            var date = $("#dateFilter").val();

                            $.ajax({
                                url: "orders/dashAction.php",
                                type: "POST",
                                data: {
                                    actionDate: actionDate,
                                    date: date,
                                },
                                success: function(data) {
                                    console.log(data);
                                    $("#myTable").html(data);
                                    $("#dateFilter").val(date);
                                }
                            });

                            var action = 'data';

                            $.ajax({
                                url: "filters/stat.php",
                                type: "POST",
                                data: {
                                    action: action,
                                    date: date,
                                },
                                success: function(data) {
                                    var res = jQuery.parseJSON(data);
                                    $("#finishedEx").html(res.a);
                                    $("#orderCount").html(res.b);
                                    $("#inProcessEx").html(res.c);

                                    if (res.a == res.b) {
                                        $('#doneEx').removeClass("text-primary");
                                        $('#doneEx').addClass("bg-gradient");
                                        $('#doneEx').addClass("bg-success");
                                        $('#doneEx').addClass("text-white");
                                    } else if (res.a != res.b) {
                                        $('#doneEx').addClass("text-primary");
                                        $('#doneEx').removeClass("bg-gradient");
                                        $('#doneEx').removeClass("bg-success");
                                        $('#doneEx').removeClass("text-white");
                                    }
                                }
                            });
                        }
                    }
                });
            }
        }).set({ title: "Задаване край на задачата" }).set({ labels: { ok: 'Да', cancel: 'Откажи' } });
    });
});

$("#can").click(function() {
    var id = $("#id").val();
    $('#canOrderID').val(id);
});
$(document).on('click', '#can', function(e) {
    $('#cancelModal').modal('show');
});



$(document).on('submit', '#uploadPhoto', function(e) {
    e.preventDefault();
    var id = $("#idForUpload").val();

    var formData = new FormData(this);
    formData.append("save_photo", true);

    $.ajax({
        type: "POST",
        url: "signIn/action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 200) {

                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#photoUploadModal').modal('hide');
                $('#uploadPhoto')[0].reset();

                $.ajax({
                    url: 'signIn/reloadPhoto.php',
                    type: "POST",
                    data: { id: id },
                    success: function(data) {
                        $('.updatePhoto').attr('src', data);
                    }
                });

            } else if (res.status == 500) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
            }
        }
    });
});

$(document).on('submit', '#cancelFormApp', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_textarea_info", true);

    $.ajax({
        type: "POST",
        url: "app/action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errMess').removeClass('d-none');
                $('#errMess').text(res.message);

            } else if (res.status == 200) {

                $('#errMess').addClass('d-none');
                $('#cancelModalApp').modal('hide');
                $('#cancelFormApp')[0].reset();
                location.reload(true);

                $('.section1').removeClass('d-none');
                $('.section1-1').addClass('d-none');
                $('.section2').removeClass('d-none');
                $('.section3').removeClass('d-none');
                $('.section4').addClass('d-none');
                $('.section5').addClass('d-none');
                $('.section8').addClass('d-none');
            }
        }
    });
});


$(document).on('submit', '#cancelForm', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_textarea", true);

    $.ajax({
        type: "POST",
        url: "orders/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errMess').removeClass('d-none');
                $('#errMess').text(res.message);

            } else if (res.status == 200) {

                $('#errMess').addClass('d-none');
                $('#cancelModal').modal('hide');
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                var actionDate = 'data';
                var date = $("#dateFilter").val();

                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        actionDate: actionDate,
                        date: date,
                    },
                    success: function(data) {
                        console.log(data);
                        $("#myTable").html(data);
                        $("#dateFilter").val(date);
                    }
                });

                var action = 'data';

                $.ajax({
                    url: "filters/stat.php",
                    type: "POST",
                    data: {
                        action: action,
                        date: date,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        $("#finishedEx").html(res.a);
                        $("#orderCount").html(res.b);
                        $("#inProcessEx").html(res.c);

                        if (res.a == res.b) {
                            $('#doneEx').removeClass("text-primary");
                            $('#doneEx').addClass("bg-gradient");
                            $('#doneEx').addClass("bg-success");
                            $('#doneEx').addClass("text-white");
                        } else if (res.a != res.b) {
                            $('#doneEx').addClass("text-primary");
                            $('#doneEx').removeClass("bg-gradient");
                            $('#doneEx').removeClass("bg-success");
                            $('#doneEx').removeClass("text-white");
                        }
                    }
                });
            }
        }
    });
});



$(document).on('submit', '#addOrder', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_order", true);

    $.ajax({
        type: "POST",
        url: "orders/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMessage').removeClass('d-none');
                $('#errorMessage').text(res.message);

            } else if (res.status == 200) {

                $('#errorMessage').addClass('d-none');
                $('#ordersModal').hide();
                $('.modal-backdrop').hide();
                $('.modal').removeClass('show');
                $('body').removeClass('modal-open').css('padding-right', '0');
                $('#addOrder')[0].reset();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                var actionDate = 'data';
                var date = $("#dateFilter").val();

                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        actionDate: actionDate,
                        date: date,
                    },
                    success: function(data) {
                        $("#myTable").html(data);
                    }
                });

                var action = 'data';

                $.ajax({
                    url: "filters/stat.php",
                    type: "POST",
                    data: {
                        action: action,
                        date: date,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        $("#finishedEx").html(res.a);
                        $("#orderCount").html(res.b);
                        $("#inProcessEx").html(res.c);

                        if (res.a == res.b) {
                            $('#doneEx').removeClass("text-primary");
                            $('#doneEx').addClass("bg-gradient");
                            $('#doneEx').addClass("bg-success");
                            $('#doneEx').addClass("text-white");
                        } else if (res.a != res.b) {
                            $('#doneEx').addClass("text-primary");
                            $('#doneEx').removeClass("bg-gradient");
                            $('#doneEx').removeClass("bg-success");
                            $('#doneEx').removeClass("text-white");
                        }
                    }
                });


            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('submit', '#changeUserPass', function(e) {
    e.preventDefault();
    var userID = $("#getCurrUserID").val();
    $("#setUserID").val(userID);

    var formData = new FormData(this);
    formData.append("change_user_password", true);

    $.ajax({
        type: "POST",
        url: "app/action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 200) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);
                $('#changeUserPass')[0].reset();
                $(".bor-bot-col1").removeAttr('style', 'border-color: #FF3131 !important');
                $(".bor-bot-col").removeAttr('style', 'border-color: #FF3131 !important');
                $(".newPassUser").css('color', 'rgba(144, 144, 144, 255)');
                $(".oldPass").css('color', 'rgba(144, 144, 144, 255)');
                $(".newPassUser").text("Нова парола");
                $(".oldPass").text("Текуща парола");
                $(".setTextInput").text("Повторете паролата");
            } else if (res.status == 210) {
                $(".oldPass").text(res.message);
                $(".bor-bot-col1").attr('style', 'border-color: #FF3131 !important');
                $(".oldPass").css('color', '#FF3131');
            } else if (res.status == 220) {
                $(".newPassUser").text(res.message);
                $(".bor-bot-col").attr('style', 'border-color: #FF3131 !important');
                $(".newPassUser").css('color', '#FF3131');
            } else if (res.status == 230) {
                $(".oldPass").text(res.message);
                $(".bor-bot-col1").attr('style', 'border-color: #FF3131 !important');
                $(".oldPass").css('color', '#FF3131');
            } else if (res.status == 240) {
                $(".newPassUser").text(res.message);
                $(".bor-bot-col").attr('style', 'border-color: #FF3131 !important');
                $(".newPassUser").css('color', '#FF3131');
            }
        }
    });
});

$(".bor-bot-col1").click(function() {
    $(".bor-bot-col1").removeAttr('style', 'border-color: #FF3131 !important');
});

$(".bor-bot-col").click(function() {
    $(".bor-bot-col").removeAttr('style', 'border-color: #FF3131 !important');
});

$(document).on('submit', '#updateOrder', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_order", true);

    $.ajax({
        type: "POST",
        url: "orders/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);

            } else if (res.status == 200) {

                $('#errorMessageUpdate').addClass('d-none');
                $('#postData').removeClass('d-none');
                $('#postData').html(res.message);


                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#оrderEditModal').modal('hide');
                $('#updateOrder')[0].reset();

                var actionDate = 'data';
                var date = $("#dateFilter").val();

                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        actionDate: actionDate,
                        date: date,
                    },
                    success: function(data) {
                        $("#myTable").html(data);
                    }
                });

                var action = 'data';

                $.ajax({
                    url: "filters/stat.php",
                    type: "POST",
                    data: {
                        action: action,
                        date: date,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        $("#finishedEx").html(res.a);
                        $("#orderCount").html(res.b);
                        $("#inProcessEx").html(res.c);

                        if (res.a == res.b) {
                            $('#doneEx').removeClass("text-primary");
                            $('#doneEx').addClass("bg-gradient");
                            $('#doneEx').addClass("bg-success");
                            $('#doneEx').addClass("text-white");
                        } else if (res.a != res.b) {
                            $('#doneEx').addClass("text-primary");
                            $('#doneEx').removeClass("bg-gradient");
                            $('#doneEx').removeClass("bg-success");
                            $('#doneEx').removeClass("text-white");
                        }
                    }
                });

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('submit', '#addTeam', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_team", true);

    $.ajax({
        type: "POST",
        url: "teams/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorrMessageee').removeClass('d-none');
                $('#errorrMessageee').text(res.message);

            } else if (res.status == 200) {

                $('#errorrMessageee').addClass('d-none');
                $('#ordersModal').hide();
                $('.modal-backdrop').hide();
                $('.modal').removeClass('show');
                $('body').removeClass('modal-open').css('padding-right', '0');
                $('#addTeam')[0].reset();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#teamTable').load(location.href + " #teamTable");
                $('#userTable').load(location.href + " #userTable");

                var actionDate = 'data';
                var date = $("#dateFilter").val();

                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        actionDate: actionDate,
                        date: date,
                    },
                    success: function(data) {
                        console.log(data);
                        $("#myTable").html(data);
                        $("#dateFilter").val(date);
                    }
                });

                var action = 'data';

                $.ajax({
                    url: "filters/stat.php",
                    type: "POST",
                    data: {
                        action: action,
                        date: date,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        $("#finishedEx").html(res.a);
                        $("#orderCount").html(res.b);
                        $("#inProcessEx").html(res.c);

                        if (res.a == res.b) {
                            $('#doneEx').removeClass("text-primary");
                            $('#doneEx').addClass("bg-gradient");
                            $('#doneEx').addClass("bg-success");
                            $('#doneEx').addClass("text-white");
                        } else if (res.a != res.b) {
                            $('#doneEx').addClass("text-primary");
                            $('#doneEx').removeClass("bg-gradient");
                            $('#doneEx').removeClass("bg-success");
                            $('#doneEx').removeClass("text-white");
                        }
                    }
                });


            } else if (res.status == 400) {
                $('#errorrMessageee').removeClass('d-none');
                $('#errorrMessageee').text(res.message);

            } else if (res.status == 320) {
                $('#errorrMessageee').removeClass('d-none');
                $('#errorrMessageee').text(res.message);

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$("#openCanModal").on('click', function() {
    $('#cancelModalApp').modal('show');
});

$(document).on('click', '#closeModalCan', function(e) {
    $('#cancelModalApp').modal('hide');
});

$("#selPos").on('change', function() {
    var position = $(this).val();
    var namePid = $("#namePid").val();

    $.ajax({
        url: "filters/positionFilter.php",
        type: "POST",
        data: {
            position: position,
            namePid: namePid
        },
        success: function(data) {
            $("#userTable").html(data);
        }
    });
});

$("#namePid").on('keyup', function() {
    var namePid = $(this).val();
    var position = $("#selPos").val();

    $.ajax({
        url: "filters/nameAndPidFilter.php",
        type: "POST",
        data: {
            namePid: namePid,
            position: position
        },
        success: function(data) {
            $("#userTable").html(data);
        }
    });
});

$(".iconSpan").on('click', function() {
    if ($("#showPass").hasClass('d-none')) {
        $('#typeChange').attr('type', 'password');
        $("#showPass").removeClass('d-none');
        $("#hidePass").addClass('d-none');
    } else if ($("#hidePass").hasClass('d-none')) {
        $('#typeChange').attr('type', 'text');
        $("#hidePass").removeClass('d-none');
        $("#showPass").addClass('d-none');
    }
});

$("#teamNumber").on('keyup', function() {
    var nameNum = $(this).val();

    $.ajax({
        url: "filters/teamNumberName.php",
        type: "POST",
        data: {
            nameNum: nameNum,
        },
        success: function(data) {
            $("#teamTable").html(data);
        }
    });
});

$("#namePid").on('keyup', function() {
    var namePid = $(this).val();
    var position = $("#selPos").val();

    $.ajax({
        url: "filters/nameAndPidFilter.php",
        type: "POST",
        data: {
            namePid: namePid,
            position: position
        },
        success: function(data) {
            $("#userTable").html(data);
        }
    });
});

$(document).on('click', '.prevOrd', function(e) {
    var idd = $(this).val();
    $('#getTeamID').val(idd);
    $('#prevORD').modal('show');
    $.ajax({
        url: "teams/dashAction.php",
        type: "POST",
        data: {
            idd: idd,
        },
        success: function(data) {
            $("#customerCard").html(data);
        }
    });
});

$(document).on('click', '.reviewCancel', function(e) {
    var idd = $(this).val();
    $.ajax({
        type: "GET",
        url: "orders/dashAction.php?id=" + idd,
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 200) {
                $('#text-areaa').val(res.data.cancelReason);
                $('#previewModal').modal('show');
            }
        }
    });
});

$(document).on('click', '.editTeamBtnn', function() {
    var id = $(this).val();
    alert(id);
});

$(document).on('click', '.openPhotoModal', function() {
    $('#photoUploadModal').modal('show');
});

$(document).on('click', '.editUserBtn', function() {
    var id = $(this).val();
    $.ajax({
        type: "GET",
        url: "users/dashAction.php?id=" + id,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 404) {

                alert(res.message);
            } else if (res.status == 200) {

                if (res.data.status == "Активен") {
                    $('#userStatus option[value="Активен"]').removeAttr('selected');
                    $('#userStatus option[value="Напуснал"]').removeAttr('selected');
                    $('#userStatus option[value="Активен"]').attr("selected", "selected");
                    $("#leftJob").addClass('d-none');
                    $('#userStatus').prop('disabled', false);
                    $("#outDate").prop('disabled', false);
                    var d = new Date();
                    if (d.getDate() < 10 && d.getMonth() + 1 < 10) {
                        var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-0" + d.getDate();
                    } else if (d.getDate() >= 10 && d.getMonth() + 1 < 10) {
                        var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-" + d.getDate();
                    } else if (d.getDate() < 10 && d.getMonth() + 1 >= 10) {
                        var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-0" + d.getDate();
                    } else if (d.getDate() >= 10 && d.getMonth() + 1 >= 10) {
                        var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
                    }
                    $("#outDate").val(strDate);
                    $('#fileImgDN').removeClass('d-none');
                    $('#userPhone').prop('disabled', false);
                    $('#egn').prop('disabled', false);
                    $('#userNamee').prop('disabled', false);
                    $('#userPos').prop('disabled', false);
                    $('#inDate').prop('disabled', false);
                    $('#modalBtnUserEdit').removeClass('d-none');
                } else if (res.data.status == "Напуснал") {
                    $('#userStatus option[value="Активен"]').removeAttr('selected');
                    $('#userStatus option[value="Напуснал"]').attr("selected", "selected");
                    $("#leftJob").removeClass('d-none');
                    $("#outDate").prop('disabled', true);
                    $('#userStatus').prop('disabled', true);
                    $("#outDate").val(res.data.outDate);
                    $('#fileImgDN').addClass('d-none');
                    $('#userPhone').prop('disabled', true);
                    $('#egn').prop('disabled', true);
                    $('#userNamee').prop('disabled', true);
                    $('#userPos').prop('disabled', true);
                    $('#inDate').prop('disabled', true);
                    $('#modalBtnUserEdit').addClass('d-none');
                }

                if (res.data.position == "Шофьор") {
                    $('#userPos option[value="Шофьор"]').attr("selected", "selected");
                } else if (res.data.position == "Хигиенист") {
                    $('#userPos option[value="Хигиенист"]').attr("selected", "selected");
                }
                $('#userImg').attr('src', 'users/userImages/' + res.data.image);
                $('#changeTitle').html(res.data.name + ' | Профил');
                $('#userId').val(res.data.id);
                $('#userNamee').val(res.data.name);
                $('#egn').val(res.data.egn);
                $('#userPhone').val(res.data.phone);
                $('#inDate').val(res.data.inDate);
                $('#setTeamID').val(res.data.teamID);
                $('#userEditModal').modal('show');
            }

        }
    });
});

$("#userEditModal").click(function() {
    $('#changeTitle').html('Администраторски панел');
});



$("#selTm").on('change', function() {
    var id = $(this).val();

    $.ajax({
        type: "GET",
        url: "orders/setOrder.php?id=" + id,
        success: function(response) {
            console.log(response);
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {

                alert(res.message);
            } else if (res.status == 200) {
                $('#teamIdSet').val(res.data.id);
                $('#selUser1').val(res.data.user1);
                $('#selUser2').val(res.data.user2);
                $('#user1id').val(res.data.user1ID);
                $('#user2id').val(res.data.user2ID);
                $('#getTeamName').val(res.data.name);
            }
        }
    });
});

$(".reviewTeam").on('click', function() {
    $('#reviewTeam').modal('hide');
});

$("#closePrevORD").on('click', function() {
    $('#prevORD').modal('hide');
});

$(document).on('click', '.column_sortt', function() {
    var action = 'data';
    var column_name = $(this).attr("name");
    var column_id = $(this).attr("id");
    var namePid = $('#namePid').val();
    var position = $("#selPos").val();
    var order = $(this).data("order");
    var arrow = '';
    if (order == 'desc') {
        arrow = '<span class="ml-1"><i class="bi bi-arrow-up"></i></span>';
    } else {
        arrow = '<span class="ml-1"><i class="bi bi-arrow-down"></i></span>';
    }

    $.ajax({
        url: "filters/columnFilterUser.php",
        method: "POST",
        data: {
            namePid: namePid,
            action: action,
            position: position,
            column_name: column_name,
            order: order
        },
        success: function(data) {
            $("#userTable").html(data);
            console.log(data);
            $('#' + column_id + '').append(arrow);

        }
    })
});


$(document).on('click', '#systemExit', function(e) {
    window.location.href = "signIn.php";
});

$(document).on('submit', '#signIn', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("send_login_info", true);

    $.ajax({
        type: "POST",
        url: "signIn/action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
                $('.emailCheck').attr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');

            } else if (res.status == 424) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
                $('.passCheck').attr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');

            } else if (res.status == 200) {

                $('#signIn')[0].reset();
                window.location.href = "dashboard.php";

            } else if (res.status == 500) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
                $('.errorShow').attr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');
            }
        }
    });
});

$(document).on('submit', '#signInMobile', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("send_login_mobile", true);

    $.ajax({
        type: "POST",
        url: "signIn/action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
                $('.emailCheck').attr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');

            } else if (res.status == 424) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
                $('.passCheck').attr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');

            } else if (res.status == 200) {

                $('#signInMobile')[0].reset();
                window.location.href = "app.php";

            } else if (res.status == 500) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
                $('.errorShow').attr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');
            }
        }
    });
});

$(document).on('click', '.errorShow', function(e) {
    $('.errorShow').removeAttr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');
    $('.passCheck').removeAttr('style', 'border-color: #f5c6cb !important; background-color: #f8d7da;');
});

$(document).on('submit', '#setOrder', function(e) {
    e.preventDefault();


    var formData = new FormData(this);
    formData.append("save_setorder", true);

    $.ajax({
        type: "POST",
        url: "orders/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMesSetOrder').removeClass('d-none');
                $('#errorMesSetOrder').text(res.message);

            } else if (res.status == 200) {

                $('#errorMesSetOrder').addClass('d-none');
                $('#setOrder')[0].reset();
                $('#setOrderModal').modal('hide');
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                var actionDate = 'data';
                var date = $("#dateFilter").val();

                $.ajax({
                    url: "orders/dashAction.php",
                    type: "POST",
                    data: {
                        actionDate: actionDate,
                        date: date,
                    },
                    success: function(data) {
                        console.log(data);
                        $("#myTable").html(data);
                        $("#dateFilter").val(date);
                    }
                });

                var action = 'data';

                $.ajax({
                    url: "filters/stat.php",
                    type: "POST",
                    data: {
                        action: action,
                        date: date,
                    },
                    success: function(data) {
                        var res = jQuery.parseJSON(data);
                        $("#finishedEx").html(res.a);
                        $("#orderCount").html(res.b);
                        $("#inProcessEx").html(res.c);

                        if (res.a != 0 && res.b != 0) {
                            if (res.a == res.b) {
                                $('#doneEx').removeClass("text-primary");
                                $('#doneEx').addClass("bg-gradient");
                                $('#doneEx').addClass("bg-success");
                                $('#doneEx').addClass("text-white");
                            } else if (res.a != res.b) {
                                $('#doneEx').addClass("text-primary");
                                $('#doneEx').removeClass("bg-gradient");
                                $('#doneEx').removeClass("bg-success");
                                $('#doneEx').removeClass("text-white");
                            }
                        }

                    }
                });

                $('#teamTable').load(location.href + " #teamTable");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('click', '.setOrder', function() {
    var id = $(this).val();
    $('#orderID').val(id);
    $('#setOrderModal').modal('show');

    var actionOr = 'data';

    $.ajax({
        url: "orders/dashAction.php",
        type: "POST",
        data: {
            actionOr: actionOr,
        },
        success: function(data) {
            $("#selTm").html(data);
        }
    });
});

$(document).on('click', '.setOrder', function() {
    $('#setOrderModal').modal('hide');
});

$(document).on('click', '.appointedBtn', function() {
    var id = $(this).val();
    $.ajax({
        type: "GET",
        url: "orders/teamView.php?id=" + id,
        success: function(response) {
            console.log(response);
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {

                alertify.set('notifier', 'position', 'top-center');
                alertify.error(res.message);
            } else if (res.status == 200) {
                $('#reviewTeam').modal('show');
                $('#getUser1').val(res.data.user1);
                $('#getUser2').val(res.data.user2);
                $('#getTeam').val(res.data.name);
            }
        }
    });
});




$(document).on('click', '.editOrderBtn', function() {
    var id = $(this).val();
    var d = new Date();
    if (d.getDate() < 10 && d.getMonth() + 1 < 10) {
        var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-0" + d.getDate();
    } else if (d.getDate() >= 10 && d.getMonth() + 1 < 10) {
        var strDate = d.getFullYear() + "-0" + (d.getMonth() + 1) + "-" + d.getDate();
    } else if (d.getDate() < 10 && d.getMonth() + 1 >= 10) {
        var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-0" + d.getDate();
    } else if (d.getDate() >= 10 && d.getMonth() + 1 >= 10) {
        var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
    }

    $.ajax({
        type: "GET",
        url: "orders/dashAction.php?id=" + id,
        success: function(response) {



            var res = jQuery.parseJSON(response);
            if (res.status == 404) {

                alert(res.message);
            } else if (res.status == 200) {
                $('#id').val(res.data.id);
                $('#name').val(res.data.customerName);
                $('#address').val(res.data.address);
                $('#phone').val(res.data.phone);
                $('#room').val(res.data.room);
                $('#offer').val(res.data.offer);
                $('#setDate').val(res.data.date);
                $('#m22').val(res.data.m2);
                $("#price3").html(res.data.price + " лв.");
                $('#endDate').val(res.data.endDate);
                $('#startDate').val(res.data.startDate);
                $('#startDatee').val(res.data.startDate);
                $('#price1').val(res.data.price);
                $('#pickTimee').val(res.data.time);
                $('#оrderEditModal').modal('show');

                var status = res.data.status;
                if (status == "Назначи") {
                    $('#name').prop('disabled', false);
                    $('#address').prop('disabled', false);
                    $('#phone').prop('disabled', false);
                    $('#room').prop('disabled', false);
                    $('#offer').prop('disabled', false);
                    $('#setDate').prop('disabled', false);
                    $('#m22').prop('disabled', false);
                    $('#pickTimee').prop('disabled', false);
                    $("#datee").addClass('d-none');
                    $("#closeEd").show();
                    $("#submitEd").show();
                    $("#endOrder").hide();
                    $("#can").hide();
                    $("#modalBtn").show();
                    $("#datee").addClass('d-none');
                } else if (status == "Назначена" || status == "В процес") {
                    $('#name').prop('disabled', true);
                    $('#address').prop('disabled', true);
                    $('#phone').prop('disabled', true);
                    $('#room').prop('disabled', true);
                    $('#offer').prop('disabled', true);
                    $('#setDate').prop('disabled', true);
                    $('#m22').prop('disabled', true);
                    $('#pickTimee').prop('disabled', true);
                    $("#closeEd").hide();
                    $("#submitEd").hide();
                    $("#modalBtn").show();
                    $("#endOrder").show();
                    $("#can").show();
                } else if (status == "Приключена" || status == "Отказана") {
                    $('#name').prop('disabled', true);
                    $('#address').prop('disabled', true);
                    $('#phone').prop('disabled', true);
                    $('#room').prop('disabled', true);
                    $('#offer').prop('disabled', true);
                    $('#setDate').prop('disabled', true);
                    $('#m22').prop('disabled', true);
                    $('#pickTimee').prop('disabled', true);
                    $("#datee").addClass('d-none');
                    $("#modalBtn").hide();
                    $("#dates").removeClass('d-none');
                } else if (strDate > res.data.date) {
                    $('#name').prop('disabled', true);
                    $('#address').prop('disabled', true);
                    $('#phone').prop('disabled', true);
                    $('#room').prop('disabled', true);
                    $('#offer').prop('disabled', true);
                    $('#setDate').prop('disabled', true);
                    $('#m22').prop('disabled', true);
                    $('#pickTimee').prop('disabled', true);
                    $("#datee").addClass('d-none');
                    $("#modalBtn").hide();
                }

                if (status == "В процес") {
                    $("#datee").removeClass('d-none');
                }

                if (status == "Назначена") {
                    $("#datee").addClass('d-none');
                }
                $('#changeTitle').html('Заявка номер ' + res.data.id);
            }
            var phone = $('#phone').val();

            $.ajax({
                type: "GET",
                url: "orders/dashAction.php?phone=" + phone,
                success: function(response) {

                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {

                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#number').val(res.data.id);
                    }
                }
            });

        }
    });
});

$("#оrderEditModal").click(function() {
    $('#changeTitle').html('Администраторски панел');
});

$(document).on('click', '#infoBtnApp', function() {
    $(".main_sec_4").removeClass('d-none');
});

$(document).on('click', '#opBtnApp', function() {
    $(".main_sec_4").addClass('d-none');
});

$(document).on('keyup', '#user2', function() {
    var user2 = $(this).val();

    $.ajax({
        url: "teams/userLiveSearch2.php",
        type: "POST",
        data: { user2: user2 },
        success: function(data) {
            $("#secondDrop").removeClass('d-none');
            $("#secondDrop").html(data);
        }
    });
});

$(document).on('keyup', '#searchBy', function() {
    var info = $(this).val();
    var sort = $('#checkedValueSort').val();

    var infoo = $(this).val();
    var sortt = $('#checkedValueSort').val();
    if ($('.finishedOr').hasClass('button-clicked')) {
        $.ajax({
            url: "app/action.php",
            type: "POST",
            data: { infoo: infoo, sortt: sortt },
            success: function(data) {
                $(".section5").html(data);
            }
        });
    } else if ($('.currOr').hasClass('button-clicked')) {
        $.ajax({
            url: "app/action.php",
            type: "POST",
            data: { info: info, sort: sort },
            success: function(data) {
                $(".section3").html(data);
            }
        });
    }

});

$(document).on('keyup', '#user1', function() {
    var user1 = $(this).val();

    $.ajax({
        url: "teams/userLiveSearch.php",
        type: "POST",
        data: { user1: user1 },
        success: function(data) {
            $("#firstDrop").removeClass('d-none');
            $("#firstDrop").html(data);
        }
    });
});

$(document).on('click', '#exitApp', function() {

    window.location.href = "signInMobile.php";
    var pid = $('#getIdForExit').val();

    $.ajax({
        url: "app/action.php",
        type: "POST",
        data: { pid: pid },
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 200) {
                $('#teamTable').load(location.href + " #teamTable");
            }
        }
    });
});


$(document).on('click', '.getNamee', function() {
    var selected = $(this).html();
    $("#secondDrop").addClass('d-none');
    var secSpace = 2;
    var split = selected.split(' ');
    var substrSelected = split.slice(0, secSpace).join(' ');
    $("#user2").val(substrSelected);

    var index = selected.indexOf(' ', selected.indexOf(' ') + 1);
    var secondSpace = selected.substr(index + 3);
    $('#firstHiddenPID1').val(secondSpace);
});

$(document).on('click', '.getName', function() {
    var selected = $(this).html();
    $("#firstDrop").addClass('d-none');
    var secSpace = 2;
    var split = selected.split(' ');
    var substrSelected = split.slice(0, secSpace).join(' ');
    $("#user1").val(substrSelected);

    var index = selected.indexOf(' ', selected.indexOf(' ') + 1);
    var secondSpace = selected.substr(index + 3);
    $('#firstHiddenPID').val(secondSpace);
});

$("#userStatus").change(function() {
    var selected = $(this)[0].selectedIndex;
    if (selected == 1) {
        $("#leftJob").removeClass('d-none');
    } else {
        $("#leftJob").addClass('d-none');
    }
});

$("#closeModal").click(function() {
    if (!$("#fooleftJob").hasClass('d-none')) {
        $("#leftJob").addClass('d-none');
    }
});

$("#subModal").click(function() {
    if (!$("#fooleftJob").hasClass('d-none')) {
        $("#leftJob").addClass('d-none');
    }
});

$(".setPassword").on('click', function() {
    $('#passwordModal').modal('hide');
});

$(".userEditModal").on('click', function() {
    $('#userEditModal').modal('hide');
});

$(document).on('click', '.passwordBtn', function() {
    var userID = $(this).val();
    $.ajax({
        type: "GET",
        url: "users/dashAction.php?id=" + userID,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 404) {

                alert(res.message);
            } else if (res.status == 200) {

                $('#userIdIn').val(res.data.id);
                $('#userNameIn').val(res.data.username);
                $('#passwordModal').modal('show');
            }

        }
    });
});

$(document).on('submit', '#setPassword', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_password", true);

    $.ajax({
        type: "POST",
        url: "users/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 400) {
                $('#passErorr').removeClass('d-none');
                $('#passErorr').text(res.message);
                $("#repPassword").css({ "border-color": "#f5c6cb", 'background-color': '#f8d7da' });
                $("#password").css({ "border-color": "#f5c6cb", 'background-color': '#f8d7da' });

            } else if (res.status == 200) {

                $('#passErorr').addClass('d-none');
                $('#passwordModal').modal('hide');
                $('#setPassword')[0].reset();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#userTable').load(location.href + " #userTable");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('click', '.back-product', function(e) {
    var name = $(this).val();
    var data = 'data';
    var strName = name.split(' ').join('-');

    $.ajax({
        url: "app/action.php",
        type: "POST",
        data: { name: name },
        success: function(response) {
            $.ajax({
                url: "app/getSum.php",
                type: "POST",
                data: {
                    data: data,
                    name: name
                },
                success: function(response) {
                    var a = $(".section7").find('.orBox1');
                    console.log(a.length);
                    if (response == 0) {
                        $('#' + strName).remove();
                        if (a.length == 1) {
                            $("#noResult").removeClass("d-none");
                        }
                    } else {
                        $('.' + strName).html(response);
                    }

                }
            });
        }
    });
});

$(document).on('click', '.back-btn', function(e) {
    var id = $(this).val();
    $('#back-product-in-wr').modal('show');

    $.ajax({
        type: "GET",
        url: "app/action.php?id=" + id,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 200) {
                $('#backProductID').val(res.data.teamID);
                $('#backProductName').val(res.data.productName);
            }
        }
    });

    $(document).on('submit', '#backProductForm', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("back_product", true);

        $.ajax({
            type: "POST",
            url: "app/backProduct.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#back-product-in-wr').modal('hide');
                $('#section7').html(response);
            }
        });
    });
});



$(document).on('click', '.back-product-in-wr', function(e) {
    $('#back-product-in-wr').modal('hide');
});

$(document).on('submit', '#addUser', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_user", true);

    $.ajax({
        type: "POST",
        url: "users/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            console.log(res);
            if (res.status == 422) {
                $('#errorrMessage').removeClass('d-none');
                $('#errorrMessage').text(res.message);

            } else if (res.status == 400) {
                $('#errorrMessage').removeClass('d-none');
                $('#errorrMessage').text(res.message);
                $("#errorPid").css({ "border-color": "#f5c6cb", 'background-color': '#f8d7da' });

            } else if (res.status == 300) {
                $('#errorrMessage').removeClass('d-none');
                $('#errorrMessage').text(res.message);
                $("#uplImg").css({ "border-color": "#f5c6cb", 'background-color': '#f8d7da' });

            } else if (res.status == 200) {

                $('#errorrMessage').addClass('d-none');
                $('#userModal').hide();
                $('.modal-backdrop').hide();
                $('.modal').removeClass('show');
                $('body').removeClass('modal-open').css('padding-right', '0');
                $('#userModal').modal('hide');
                $('#addUser')[0].reset();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#userTable').load(location.href + " #userTable");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('submit', '#addProduct', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("save_product", true);

    $.ajax({
        type: "POST",
        url: "warehouse/action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);

            if (res.status == 422) {
                $('#errMes').removeClass('d-none');
                $('#errMes').text(res.message);

            } else if (res.status == 200) {

                $('#errMes').addClass('d-none');
                $('#addProductModal').modal('hide');
                $('#addProduct')[0].reset();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#productTable').load(location.href + " #productTable");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('change', '#selKind', function(e) {

    var sel_Index = $(this)[0].selectedIndex;

    if (sel_Index == 1) {
        $('#ProdInsertNum').val("0100");
    }
    if (sel_Index == 2) {
        $('#ProdInsertNum').val("0200");
    }
    if (sel_Index == 3) {
        $('#ProdInsertNum').val("0300");
    }
});

$("#openUserModal").click(function() {
    $("#errorPid").css({ "border-color": "#ced4da", 'background-color': 'white' });
    $("#uplImg").css({ "border-color": "#ced4da", 'background-color': 'white' });
});

$(document).on('click', '#openModalProd', function(e) {
    $('#addProductModal').modal('show');
});

$(document).on('click', '.closeUploadModal', function(e) {
    $('#photoUploadModal').modal('hide');
});

$(document).on('click', '.out-border', function(e) {
    $('#exRotate').removeClass('box-btn-active');
    $('#werHbtn').removeClass('box-btn-active');
    $('.section1').addClass('d-none');
    $('.section1-1').removeClass('d-none');
    $('.section2').addClass('d-none');
    $('.section3').addClass('d-none');
    $('.section4').addClass('d-none');
    $('.section5').addClass('d-none');
    $('.section6').removeClass('d-none');
    $('.section7').addClass('d-none');
    $('.section8').addClass('d-none');
});

$(document).on('click', '.boxBtn', function(e) {
    var id = $(this).val();

    $.ajax({
        type: "GET",
        url: "app/action.php?id=" + id,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 404) {

                alert(res.message);
            } else if (res.status == 200) {

                if (res.data.status == 'В процес') {
                    $('.section8').removeClass('d-none');
                    $('.section1').addClass('d-none');
                    $('.section1-1').removeClass('d-none');
                    $('.section2').addClass('d-none');
                    $('.section3').addClass('d-none');
                    $('.section4').addClass('d-none');
                    $('.section5').addClass('d-none');
                    $('.section7').addClass('d-none');
                    $('#kindRoomInProcess').html(res.data.room);
                    $('#continueStep').val(res.data.id);
                } else {
                    $('.section8').addClass("d-none");
                    $('.section1').addClass('d-none');
                    $('.section1-1').addClass('d-none');
                    $('.section2').addClass('d-none');
                    $('.section3').addClass('d-none');
                    $('.section4').removeClass('d-none');
                    $('.section5').addClass('d-none');
                    $('.section7').addClass('d-none');
                    $('.section8').addClass('d-none');

                    var year = res.data.date.substr(0, res.data.date.indexOf('-'));

                    var n = 2;
                    var a = res.data.date.split('-');
                    var day = a.slice(n).join('-');

                    var index = res.data.date.indexOf('-', res.data.date.indexOf('-') + 1);
                    var firstChunk = res.data.date.substr(0, index);
                    var index1 = firstChunk.indexOf('-');
                    var month = firstChunk.substr(index1 + 1);

                    var curDate = day + "." + month + "." + year;

                    $('#custName').html(res.data.customerName);
                    $('.planStart').html(curDate);
                    $('#planTime').html(res.data.time);

                    if (res.data.m2 < 100) {
                        var hour = res.data.time.substr(0, res.data.time.indexOf(':'));
                        var parseHour = parseInt(hour);
                        var n = 1;
                        var a = res.data.time.split(':');
                        var get = a.slice(n).join(':');
                        var min = get.substr(0, get.indexOf(':'));
                        var curTime = parseHour + 1 + ":" + min + ":" + "00";
                        $('#planEnd').html(curTime);
                    } else if (res.data.m2 < 500) {
                        var hour = res.data.time.substr(0, res.data.time.indexOf(':'));
                        var parseHour = parseInt(hour);
                        var n = 1;
                        var a = res.data.time.split(':');
                        var get = a.slice(n).join(':');
                        var min = get.substr(0, get.indexOf(':'));
                        var curTime = parseHour + 2 + ":" + min + ":" + "00";
                        $('#planEnd').html(curTime);
                    } else if (res.data.m2 < 1000) {
                        var hour = res.data.time.substr(0, res.data.time.indexOf(':'));
                        var parseHour = parseInt(hour);
                        var n = 1;
                        var a = res.data.time.split(':');
                        var get = a.slice(n).join(':');
                        var min = get.substr(0, get.indexOf(':'));
                        var curTime = parseHour + 3 + ":" + min + ":" + "00";
                        $('#planEnd').html(curTime);
                    }

                    if (res.data.status == "Назначена") {
                        $('.btn-ex').removeClass('d-none');
                    } else if (res.data.status == "Отказана") {
                        $('.btn-ex').addClass('d-none');
                    } else if (res.data.status == "Приключена") {
                        $('.btn-ex').addClass('d-none');
                    }

                    $('#getAddress').html(res.data.address);
                    $('#getM2').html(res.data.m2 + " квадратни метра");
                    $('#methodPay').html(res.data.pay);
                    $('#disPrice').html(res.data.price + " лв.");
                    $('#getOffer').html(res.data.offer);
                    $('#getPhone').html(res.data.phone);
                    $('#orderIDget').val(res.data.id);
                    $('#kindRoom').html(res.data.room);
                    $('#orderStartBtn').val(res.data.id);
                    $('#continueStep').val(res.data.id);
                    $('#kindRoomInProcess').html(res.data.room);
                }
            }

        }
    });
});

$(document).on('click', '#backProductModal', function(e) {
    $('#backProductModal').modal('hide');
});

$(document).on('submit', '#updateUser', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("update_user", true);

    $.ajax({
        type: "POST",
        url: "users/dashAction.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {

            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);

            } else if (res.status == 200) {
                $('#errorMessageUpdate').addClass('d-none');
                $('#postData').removeClass('d-none');
                $('#postData').html(res.message);

                alertify.set('notifier', 'position', 'top-center');
                alertify.success(res.message);

                $('#userEditModal').modal('hide');
                $('#updateUser')[0].reset();

                $('#userTable').load(location.href + " #userTable");
                $('#teamTable').load(location.href + " #teamTable");

            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
});

$(document).on('click', '#showSortModal', function(e) {
    $('#sortByModal').modal('show');
});

$(document).on('click', '.currOr', function(e) {
    $('.section3').removeClass('d-none');
    $('.section5').addClass('d-none');
});

$(document).on('click', '#continueStep', function(e) {
    var iddd = $(this).val();
    $.ajax({
        type: "POST",
        url: "app/action.php",
        data: { iddd: iddd },
        success: function(response) {
            location.reload(true);
            console.log(response);
        }
    });
});

$(document).on('click', '#orderStartBtn', function(e) {
    var idd = $(this).val();

    $('.section1').addClass('d-none');
    $('.section1-1').removeClass('d-none');
    $('.section2').addClass('d-none');
    $('.section3').addClass('d-none');
    $('.section4').addClass('d-none');
    $('.section5').addClass('d-none');
    $('.section6').addClass('d-none');
    $('.section7').addClass('d-none');
    $('.section8').removeClass('d-none');

    $.ajax({
        type: "POST",
        url: "app/action.php",
        data: { idd: idd },
        success: function(response) {
            console.log(response);
        }
    });
});

$(document).on('click', '#exRotate', function(e) {
    $(this).addClass('box-btn-active');
    $('#werHbtn').removeClass('box-btn-active');
    $('.section1').removeClass('d-none');
    $('.section1-1').addClass('d-none');
    $('.section2').removeClass('d-none');
    $('.section3').removeClass('d-none');
    $('.section4').addClass('d-none');
    $('.section5').addClass('d-none');
    $('.section6').addClass('d-none');
    $('.section7').addClass('d-none');
    $('.section8').addClass('d-none');
});

$(document).on('click', '#werHbtn', function(e) {
    $(this).addClass('box-btn-active');
    $('#exRotate').removeClass('box-btn-active');
    $('.section1').addClass('d-none');
    $('.section1-1').removeClass('d-none');
    $('.section2').addClass('d-none');
    $('.section3').addClass('d-none');
    $('.section4').addClass('d-none');
    $('.section5').addClass('d-none');
    $('.section6').addClass('d-none');
    $('.section7').removeClass('d-none');
    $('.section8').addClass('d-none');
});

$(document).on('click', '.finishedOr', function(e) {
    $('.section5').removeClass('d-none');
    $('.section3').addClass('d-none');
});

$(window).on("load", function() {
    $(".loader-wrapper").fadeOut("slow");
});

$("#reloadBtn").click(function() {
    $(".rotate").toggleClass("down");
});

$("#reloadBtnn").click(function() {
    $(".rotatee").toggleClass("down");
    $('.fa-box-archive').removeClass('d-none');
    $('.fa-box-open').addClass('d-none');
    location.reload(true);
});

$("#exRotate").click(function() {
    $(".rotate").toggleClass("down");
    $('.fa-box-archive').removeClass('d-none');
    $('.fa-box-open').addClass('d-none');
});

$(".rotate").toggleClass("down");
$(".rotatee").toggleClass("down");

$("#werHbtn").click(function() {
    $('.fa-box-archive').addClass('d-none');
    $('.fa-box-open').removeClass('d-none');
});

$('#checkSortBtn').click(function() {
    $('#checkedValueSort').val(getChecklistItems());
});

$('.mdlBtn').click(function() {
    $('#sortByModal').modal('hide');
});

function getChecklistItems() {
    var result = $("input:radio:checked").get();

    var data = $.map(result, function(element) {
        return $(element).val();
    });

    return data.join("-");
}

$('.currOr').click(function() {
    $(this).addClass('button-clicked');
    $('.finishedOr').removeClass('button-clicked');
});

$('.finishedOr').click(function() {
    $(this).addClass('button-clicked');
    $('.currOr').removeClass('button-clicked');
});

$('#infoBtnApp').click(function() {
    $(this).addClass('button-clicked');
    $('#opBtnApp').removeClass('button-clicked');
});

$('#opBtnApp').click(function() {
    $(this).addClass('button-clicked');
    $('#infoBtnApp').removeClass('button-clicked');
});

var countAll = $('#orCountAll').val();
var count = $('#orCount').val();
var count1 = $('#orCount1').val();

var res = (count * 100) / countAll;
var res1 = (count1 * 100) / countAll;

var ctx = document.getElementById('todayOrderChart');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Активни', 'Приключени или отказани'],
        datasets: [{
            data: [res.toFixed(0), res1.toFixed(0)],
            backgroundColor: [
                'rgb(193, 225, 193)',
                'rgb(250, 160, 160)'
            ],
            hoverOffset: 4
        }]
    },
    plugins: [ChartDataLabels],
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    font: {
                        size: 15
                    },
                    color: 'rgb(145,145,145)',
                }
            },
            title: {
                display: true,
                text: 'Задачи за деня',
                color: 'rgb(145,145,145)',
                font: {
                    size: 20
                }
            },
            datalabels: {
                formatter: (value, context) => {
                    return value + '%';
                },
                color: 'white',
                font: {
                    weight: '600',
                    size: 14
                },
            }
        }
    }
});