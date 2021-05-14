        $('#start').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            "autoApply": true,
            "opens": 'right',
            "minDate": new Date(),
            "autoUpdateInput": false,
        }, function (start, end, label) {
        });
        
        
        if (livestyle == null) {
            $('#start').data('daterangepicker').setStartDate(check_in);
            $('#start').data('daterangepicker').setEndDate(check_out);
        } else {
            $('#start').data('daterangepicker').setStartDate(new Date());
            $('#start').data('daterangepicker').setEndDate(new Date());
        }
        
        $('#r_sex').selectize();
        
        var de = $('#start').data('daterangepicker');
        var district_select = $('#district').selectize({preload:true});
        district_select[0].selectize.setValue(district);
        
        $('#start').on('apply.daterangepicker', function (ev, picker) {
            updateTextDate(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
        });
        
        $('#register_button').on('click', function (e) {
            if (document.getElementById("register_form").checkValidity()) {
                var form_data = new FormData(document.getElementById("register_form"));
                $.ajax({
                    type: "POST",
                    url: "register_insert.php",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data == 'WP') {
                            Swal.fire({
                                icon: 'error',
                                title: 'The Retype password is not the same with the password.',
                                text: 'Please input again',
                            })
                        } else if (data == 'WE') {
                            Swal.fire({
                                icon: 'error',
                                title: 'The email is used, please use the another email address to register.',
                                text: 'Please input again',
                            })                           
                        } else if (data == 'WM') {
                            Swal.fire({
                                icon: 'error',
                                title: 'The Mobile number is wrong, you must start from 4-9.',
                                text: 'Please input again',
                            })                           
                        } else if (data == 'WA') {
                            Swal.fire({
                                icon: 'error',
                                title: 'You have not enough 18 years old.',
                                text: 'Please input a valid age',
                            })                           
                        } else if (data == 'WS') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registration success',
                                text: 'Please check the email and active the account',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                } 
                            })                           
                        }
                    },
                    error: function () {
                    }
                })
            } else {
                console.log("t");
            }
        });

        
        function updateTextDate(start, end) {
            $('#start').val(start);
            $('#end').val(end);
        }
        
        let rooms = [];
        $('#data-container div').each(function(i, room) {
        	return rooms.push(room);
        	console.log(rooms);
        });

        $('#pagination-container').pagination({
            dataSource: rooms,
            className: 'paginationjs-big',
            pageSize: 8,
            callback: function(data, pagination) {
                $('#data-container').html(data);
            }
        })
        
        function increase(e) {
            $("#guest_clear").css("visibility", "visible");
            var input = $(e).parents(".guest_type").find(".guest_no");
            var val = parseInt(input.html(), 10);

            if (parseInt($("#child").html(), 10) == 0 && parseInt($("#infant").html(), 10) == 0 && parseInt($("#adult").html(), 10) == 0) {
                $("#adult").html(parseInt($("#adult").html(), 10) + 1);
            }

            input.html(val + 1);

            if (parseInt($("#adult").html(), 10) == 11) {
                input.html(val);
            }
            if (parseInt($("#child").html(), 10) == 6 || parseInt($("#infant").html(), 10) == 6) {
                input.html(val);
            }

            if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 1 && parseInt($("#infant").html(), 10) > 1) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guests, " + parseInt($("#infant").html(), 10) + " infants");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 1 && parseInt($("#infant").html(), 10) > 0) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guests, " + parseInt($("#infant").html(), 10) + " infant");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0 && parseInt($("#infant").html(), 10) > 1) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guest, " + parseInt($("#infant").html(), 10) + " infants");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0 && parseInt($("#infant").html(), 10) > 0) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guest, " + parseInt($("#infant").html(), 10) + " infant");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 1) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guests");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guest");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0) { 
                $("#guest").val(parseInt($("#adult").html(), 10) + " guests");
            } else {
                $("#guest").val(1 + " guest");
            }
        }

        function decrease(e) {
            var input = $(e).parents(".guest_type").find(".guest_no");
            var val = parseInt(input.html(), 10);

            if (val > 0) {
                input.html(val - 1);
            }

            if (((parseInt($("#child").html(), 10) >= 1 || parseInt($("#infant").html(), 10) >= 1) && parseInt($("#adult").html(), 10) == 0)) {
                $("#adult").html(1);
            }
            
            if (parseInt($("#adult").html(), 10) == 0 && parseInt($("#child").html(), 10) == 0 && parseInt($("#infant").html(), 10) == 0) {
                $("#guest").val("");
                $("#guest_clear").css("visibility", "hidden");
            }

            if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 1 && parseInt($("#infant").html(), 10) > 1) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guests, " + parseInt($("#infant").html(), 10) + " infants");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 1 && parseInt($("#infant").html(), 10) > 0) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guests, " + parseInt($("#infant").html(), 10) + " infant");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0 && parseInt($("#infant").html(), 10) > 1) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guest, " + parseInt($("#infant").html(), 10) + " infants");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0 && parseInt($("#infant").html(), 10) > 0) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guest, " + parseInt($("#infant").html(), 10) + " infant");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 1) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guests");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0) {
                $("#guest").val((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) + " guest");
            } else if ((parseInt($("#adult").html(), 10) + parseInt($("#child").html(), 10)) > 0) { 
                $("#guest").val(parseInt($("#adult").html(), 10) + " guests");
            } else {
                $("#guest").val();
            }
        }