        function check_payment() {
            document.payment_form.action ="charge?id=" + id + "&adults=" + adults + "&children=" + children + "&infants=" + infants + "&check_in=" + check_in + "&check_out=" + check_out;
        }
        
        var de = $('#date_range').data('daterangepicker');
        var new_check_in;
        var new_Check_out;

        $('#date_range').on('apply.daterangepicker', function (ev, picker) {
            updateTextDate(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
            new_check_in = picker.startDate.format('YYYY-MM-DD');
            new_check_out = picker.endDate.format('YYYY-MM-DD');
        });

        function updateTextDate(start, end) {
            window.history.replaceState(null, null, "?id=" + id + "&adults=" + adults + "&children=" + children + "&infants=" + infants + "&check_in=" + start + "&check_out=" + end);

            oneDay = 24 * 60 * 60 * 1000;
            startDate = new Date(start);
            endDate = new Date(end);
            diffDays = Math.round(Math.abs((startDate - endDate) / oneDay));
            const fee = parseInt(document.getElementById("night-fee").innerHTML.replace(/\,/g,''),10);;
            const night_fee = fee * diffDays
            const service = 80;
            total = night_fee + service;

            $('#date_range').val(start + " - " + end);
            $('#all-fee').css('display', 'block');
            $('#fee-area').css('display', 'block');
            $('#night-fee').html(numberWithCommas(night_fee));
            $('#total').html(numberWithCommas(total));

            if (diffDays > 1) {
                $('#nights').html(diffDays + " nights");
            } else {
                $('#nights').html("1 night");
            }
        }

        $("#guest_clear").click(function () {
            $("#guest").val("1 guest");
            $("#adult").html(1);
            $("#child").html(0);
            $("#infant").html(0);
            $("#guest_clear").css("visibility", "hidden");
        });

        $("#check-availability").click(function () {
            $('#start').focus();
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

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function show_guests() {
            var x = document.getElementById("guest_detail");
            if (x.style.display == "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }

        $(document).on('click', function (e) {
            if ($(e.target).closest('#guest').length) {
                $("#guest_detail").show();
            } else if (!$(e.target).closest('#guest_detail').length) {
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
            
            if ($("#date_range").val() == "") {
                window.history.pushState('details', 'Title', '/book?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html());
            } else {
                window.history.pushState('details', 'Title', '/book?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html() + "&check_in=" + new_check_in +"&check_out=" + new_check_out);
            }
        }

        function decrease(e) {
            var input = $(e).parents(".guest_type").find(".guest_no");
            var val = parseInt(input.html(), 10);

            if (input[0].id == "adult" & val == 1) {
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
            
            if ($("#date_range").val() == "" || $("#end").val() == "") {
                window.history.pushState('details', 'Title', '/book?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html());
            } else {
                window.history.pushState('details', 'Title', '/book?id=' + id + "&adults=" + parseInt($("#adult").html(), 10) + "&children=" + parseInt($("#child").html(), 10)+ "&infants=" + $("#infant").html() + "&check_in=" + new_check_in +"&check_out=" + new_check_out);
            }
        }

        $(document).ready(function ($) {
            if ($(this).scrollTop() > 50) {
                $('.back-to-top').fadeIn('slow');
            } else {
                $('.back-to-top').fadeOut('slow');
            }
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('.back-to-top').fadeIn('slow');
                } else {
                    $('.back-to-top').fadeOut('slow');
                }
                if ($(this).scrollTop() > 100) {
                    $('#img-prev').css('display', 'none');
                    $('#img-next').css('display', 'none');
                } else {
                    $('#img-prev').css('display', 'block');
                    $('#img-next').css('display', 'block');
                }
            });
            $(window).load(function () {
                if ($(this).scrollTop() > 50) {
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
        });