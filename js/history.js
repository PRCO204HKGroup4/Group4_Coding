        function show_userfunction() {
            if (document.getElementById("user_function").style.display == "block") {
                $("#user_function").hide();
            } else {
                $("#user_function").show();
            }
        }
        
        
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
        
        $('.comment_button').click(function () {
            Swal.fire({
                title: 'Leave your comment',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                input: 'radio',
                inputOptions: {1:'1',2:'2',3:'3',4:'4',5:'5'},
                html: '<textarea aria-label="Type your comment here" class="swal2-textarea" placeholder="Type your comment here..." id="swal2-input" style="display: flex;"></textarea>'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "leave_comment.php",
                        data: {history_id: $(this).closest("div.content").find("input[type=hidden]").val(), comment: document.getElementById("swal2-input").value, rating: result.value},
                        success: function (data) {
                            location.reload();
                        },
                        error: function () {
                        }
                    });
                }
            })
        });
    
        function logout() {
            $.ajax({
                type: "POST",
                url: "logout.php",
                data: {},
                success: function (data) {
                    location.href = "https://monistic-hotel.com";
                },
                error: function () {
                }
            });
        }

        
        $(document).ready(function ($) {
            if ($(this).scrollTop() > 50) {
                $('.back-to-top').fadeIn('slow');
                $('#header').addClass('header-fixed');
            } else {
                $('.back-to-top').fadeOut('slow');
                $('#header').removeClass('header-fixed');
            }
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('.back-to-top').fadeIn('slow');
                    $('#header').addClass('header-fixed');
                } else {
                    $('.back-to-top').fadeOut('slow');
                    $('#header').removeClass('header-fixed');
                }
                if ($(this).scrollTop() > 100) {
                    $('#img-prev').css('display','none');
                    $('#img-next').css('display','none');
                } else {
                    $('#img-prev').css('display','block');
                    $('#img-next').css('display','block');
                }
            });
            $(window).load(function(){
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
            $("#login_button").click(function() {
                document.body.classList.add("stop-scrolling"); 
            });
            $(".lw-overlay").click(function() {
                document.body.classList.remove("stop-scrolling"); 
            });
            $(".lw-close").click(function() {
                document.body.classList.remove("stop-scrolling"); 
            });
        });
