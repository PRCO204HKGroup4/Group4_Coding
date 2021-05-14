
        var startDate = $("#start").val();
        var endDate = $("#end").val();

        function isDateAvailable(date){
            return naArray.indexOf(date.format('YYYY-MM-DD')) > -1;
        }

        $('#start').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            "autoApply": true,
            "opens": 'right',
            "minDate": new Date(),
            "autoUpdateInput": false,
            isInvalidDate: isDateAvailable
        }, function (start, end, label) {
        });
        
        
        if (check_in != null && check_out != null) {
            $('#start').data('daterangepicker').setStartDate(check_in);
            $('#start').data('daterangepicker').setEndDate(check_out);
        } else {
            $('#start').data('daterangepicker').setStartDate(new Date());
            $('#start').data('daterangepicker').setEndDate(new Date());
        }

        
        $('#r_sex').selectize();

        var de = $('#start').data('daterangepicker');

        $('#start').on('apply.daterangepicker', function(ev, picker) {
            updateTextDate(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
            window.history.pushState('details', 'Title', '/details?id=' + id + "&adults=" + adults + "&children=" + children + "&infants=" + infants + "&check_in=" + picker.startDate.format('YYYY-MM-DD') + "&check_out=" + picker.endDate.format('YYYY-MM-DD'));
        });
        
        function updateTextDate(start, end) {
            const oneDay = 24 * 60 * 60 * 1000;
            const startDate = new Date(start);
            const endDate = new Date(end);
            const diffDays = Math.round(Math.abs((startDate - endDate) / oneDay));
            const fee = parseInt(document.getElementById("night-fee").innerHTML.replace(/\,/g,''),10);
            const night_fee = fee * diffDays;
            const service = 80;
            const total = night_fee + service;
        
            $('#start').val(start);
            $('#end').val(end);
            $('#all-fee').css('display','block');
            $('#fee-area').css('display','block');
            $('#night-fee').html(numberWithCommas(night_fee));
            $('#total').html(numberWithCommas(total));
        
            if (diffDays > 1) {
                $('#nights').html(diffDays + " nights");
            } else {
                $('#nights').html("1 night");
            }
            
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
                                text: 'You can login now'
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
            }
        });

        
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
                
                if ($(this).scrollTop() > 200) {
                    $('#img-next').css('display','none');
                    $('#img-prev').css('display','none');
                } else {
                    $('#img-next').css('display','block');
                    $('#img-prev').css('display','block');
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
                $('html, body').animate({
                    scrollTop: 0
                }, 1500, 'easeInOutExpo');
                return false;
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
            $("#check_availability").click(function() {
                if (($("#start").val() != "" && $("#end").val() != "" && $("#guest").val() != "") && $("#adult").html() > 0) {
                     window.location.href = "https://monistic-hotel.com/book?id=" + id + "&adults=" + $("#adult").html() + "&children=" + $("#child").html() + "&infants=" + $("#infant").html() + "&check_in=" + $("#start").val() +"&check_out=" + $("#end").val();
                }
            })
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
            
            if ($("#start").val() == "" || $("#end").val() == "") {
                window.history.pushState('details', 'Title', '/details?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html());
            } else {
                window.history.pushState('details', 'Title', '/details?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html() + "&check_in=" + $("#start").val() +"&check_out=" + $("#end").val());
            }
        }
        
        function decrease(e) {
            var input = $(e).parents(".guest_type").find(".guest_no");
            var val = parseInt(input.html(), 10);
        
            if (input[0].id == "adult" & val > 0) {
                $("#adult").html(1);
            } else if (val > 0) {
                input.html(val - 1);
            }
        
            if (((parseInt($("#child").html(), 10) >= 1 || parseInt($("#infant").html(), 10) >= 1) && parseInt($("#adult").html(), 10) == 1)) {
                $("#adult").html(1);
            }
            
            if (parseInt($("#adult").html(), 10) == 1 && parseInt($("#child").html(), 10) == 0 && parseInt($("#infant").html(), 10) == 0) {
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
                $("#guest").val("1 guest");
            }
            
            if ($("#start").val() == "" || $("#end").val() == "") {
                window.history.pushState('details', 'Title', '/details?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html());
            } else {
                window.history.pushState('details', 'Title', '/details?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html() + "&check_in=" + $("#start").val() +"&check_out=" + $("#end").val());
            }
        }
        
        document.addEventListener( 'DOMContentLoaded', function () {
            var secondarySlider = new Splide('#thumbnail',{
                fixedWidth  : 50,
                height      : 60,
                gap         : 10,
                cover       : true,
                isNavigation: true,
                focus       : 'center',
                breakpoints : {
                    '600': {
                        fixedWidth: 66,
                        height    : 40,
                    }
                },
            }).mount();
            
            var primarySlider = new Splide('#sync',{
                type       : 'fade',
                heightRatio: 0.1,
                pagination : true,
                arrows     : true,
                cover      : true,
            });

            new Splide('#other-choice').mount();
            
            primarySlider.sync(secondarySlider).mount();
        });