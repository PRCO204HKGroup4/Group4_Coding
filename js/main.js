        var startDate = $("#start").val();
        var endDate = $("#end").val();
        $('#district').selectize({
            preload: true
        });
        
        $('#start').daterangepicker({
            "autoApply": true,
            "opens": 'right',
            "minDate": new Date(),
            "autoUpdateInput": false,
        }, function(start, end, label) {
        });
        
        $('#dob').daterangepicker({
            "autoApply": true,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1900,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            if (years < 18) {
                Swal.fire({
                    icon: 'error',
                    title: 'You are not over 18 years old!',
                    text: 'Please input a valid age',
                })
            }
        });
        
        $('#r_dob').daterangepicker({
            "autoApply": true,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1900,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            if (years < 18) {
                Swal.fire({
                    icon: 'error',
                    title: 'You are not over 18 years old!',
                    text: 'Please input a valid age',
                })
            }
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
                        console.log(data);
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
                                text: 'You can login now'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    //location.reload();
                                } 
                            })                           
                        }
                    },
                    error: function () {
                    }
                })
            } else {
            }
        });

        var de = $('#start').data('daterangepicker');

        $('#start').on('apply.daterangepicker', function(ev, picker) {
            updateTextDate(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
        });

        $("#card_search").click(function(){
            $('#location').focus();
        });
        
        $("#location_clear").click(function(){
            $("#location").val('');
            $("#location_clear").css("visibility", "hidden");
        });

        $("#guest_clear").click(function(){
            $("#guest").val('');
            $("#adult").html(0);
            $("#child").html(0);
            $("#infant").html(0);
            $("#guest_clear").css("visibility", "hidden");
        });

        $("#start_clear").click(function(){
            $("#start").val('');
            $("#start_clear").css("visibility", "hidden");
            $("#end").val('');
            $("#end_clear").css("visibility", "hidden");
            de.setStartDate(new Date);
            de.setEndDate(new Date);
        });

        $("#end_clear").click(function(){
            $("#end").val('');
            $("#end_clear").css("visibility", "hidden");
            $("#start").val('');
            $("#start_clear").css("visibility", "hidden");
            de.setStartDate(new Date);
            de.setEndDate(new Date);
        });

        function clear_location() {
            if (document.getElementById("location").value.length > 0) {
                $("#location_clear").css("visibility", "visible");
            } else {
                $("#location_clear").css("visibility", "hidden");
            }
        }

        function clear_guest() {
            if (document.getElementById("location").value.length > 0) {
                $("#location_clear").css("visibility", "visible");
            } else {
                $("#location_clear").css("visibility", "hidden");
            }
        }

        function clear_calendar() {
            if (document.getElementById("start").value.length > 0) {
                $("#start_clear").css("visibility", "visible");
            } else {
                $("#start_clear").css("visibility", "hidden");
            }
        }

        function updateTextDate(start, end) {
            $('#start').val(start);
            $('#end').val(end);

            if (document.getElementById("start").value.length > 0) {
                $("#start_clear").css("visibility", "visible");
            } else {
                $("#start_clear").css("visibility", "hidden");
            }

            if (document.getElementById("end").value.length > 0) {
                $("#end_clear").css("visibility", "visible");
            } else {
                $("#end_clear").css("visibility", "hidden");
            }
        }

        $('#end').on('focus', function() {
            $('#start').focus();
        });

        $('#search_header_bar').on('click', function() {
            $('#location').focus();
            $('#search_header_bar').css('display','none');
        });

        function show_guests() {
            var x = document.getElementById("guest_detail");
            if (x.style.display == "block") {
                $("#guest_detail").removeAttr("style").hide();
            } else {
                x.style.display = "block";
            }
        }
        
        function show_userfunction() {
            if (document.getElementById("user_function").style.display == "block") {
                $("#user_function").hide();
            } else {
                $("#user_function").show();
            }
        }

        $(document).on('click', function(e) {
            if ( $(e.target).closest('#guest').length ) {
                $("#guest_detail").show();
            }else if ( ! $(e.target).closest('#guest_detail').length ) {
                $('#guest_detail').hide();
            }
        });

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
        
        $(document).ready(function ($) {
            if ($(this).scrollTop() > 80) {
                $('.back-to-top').fadeIn('slow');
                $('#header').addClass('header-fixed');
            } else {
                $('.back-to-top').fadeOut('slow');
                $('#header').removeClass('header-fixed');
            }
            $(window).scroll(function () {
                if ($(this).scrollTop() > 80) {
                    $('.back-to-top').fadeIn('slow');
                    $('#header').addClass('header-fixed');
                } else {
                    $('.back-to-top').fadeOut('slow');
                    $('#header').removeClass('header-fixed');
                }
                if ($(this).scrollTop() > 1400) {
                    $('#search_header_bar').css('display','block');
                } else {
                    $('#search_header_bar').css('display','none');
                }
            });
            $(window).load(function(){
                if ($(this).scrollTop() > 100) {
                    $('.back-to-top').fadeIn('slow');
                } else {
                    $('.back-to-top').fadeOut('slow');
                }
            });
            $('.back-to-top').click(function () {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0; 
            });
            $("#login_button").click(function() {
                document.body.classList.add("stop-scrolling"); 
            });
            $(".lw-overlay").click(function() {
                document.body.classList.remove("stop-scrolling"); 
            });
            $(".lw-close").click(function() {
                document.body.classList.remove("stop-scrolling"); 
            });
            $("#search_submit").click(function() {
                if ($("#district").val() != "" && $("#district").val() != "" && $("#start").val() != "" && $("#end").val() != "") {
                    window.location.href = "https://monistic-hotel.com/result?district=" + $("#district").val() + "&adults=" + $("#adult").html() + "&children=" + $("#child").html() + "&infants=" + $("#infant").html() + "&check_in=" + $("#start").val() +"&check_out=" + $("#end").val(); 
                }
            })
        });
        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                  $('#profile_img').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
        
        $("#profile_file").change(function() {
            readURL(this);
        });
        
        function login() {
            if ($("#email").val() != "" && $("#password").val() != "") {
                $.ajax({
                    type: "POST",
                    url: "login_checking.php",
                    data: {email: $("#email").val(),password: $("#password").val()},
                    success: function (data) {
                        if(data == "OS") {
                            location.reload();
                        } else if (data == "OP") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Wrong Password!',
                                text: 'Please input the correct password',
                            })
                        } else if (data == "OA") {
                            Swal.fire({
                                icon: 'error',
                                title: 'This account does not exist!',
                                text: 'Please register your own account first',
                            })
                        } else if (data == "OB") {
                            Swal.fire({
                                icon: 'error',
                                title: 'This account has not been activated!',
                                text: 'Please check your email and activate this account first',
                            })
                        }
                    },
                    error: function () {
                    }
                });
            }
        }

        function logout() {
            $.ajax({
                type: "POST",
                url: "logout.php",
                data: {},
                success: function (data) {
                    //if(data == "success") {
                        location.reload();
                    //}
                },
                error: function () {
                }
            });
        }