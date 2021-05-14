const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const livestyle = urlParams.get('livestyle');
const infants = urlParams.get('infants');
const children = urlParams.get('children');
const adults = urlParams.get('adults');
const district = urlParams.get('district');
var check_in = urlParams.get('check_in');
var check_out = urlParams.get('check_out');
const id = urlParams.get('id');
var today = new Date();
var dd = today.getDate();

var mm = today.getMonth()+1; 
var yyyy = today.getFullYear();
if(dd<10) 
{
    dd='0'+dd;
} 

if(mm<10) 
{
    mm='0'+mm;
}

var oneDay;
var startDate;
var endDate;
var diffDays;

$("#card_search").click(function(){
    $('#location').focus();
});

$("#location_clear").click(function(){
    $("#location").val('');
    $("#location_clear").css("visibility", "hidden");
});

$("#guest_clear").click(function(){
    $("#guest").val("1 guest");
    $("#adult").html(1);
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
    $('#all-fee').css('display','none');
    $('#fee-area').css('display','none');
});

$("#end_clear").click(function(){
    $("#end").val('');
    $("#end_clear").css("visibility", "hidden");
    $("#start").val('');
    $("#start_clear").css("visibility", "hidden");
    de.setStartDate(new Date);
    de.setEndDate(new Date);
    $('#all-fee').css('display','none');
    $('#fee-area').css('display','none');
});

$("#check-availability").click(function(){
    $('#start').focus();
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
        x.style.display = "none";
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

function logout() {
    $.ajax({
        type: "POST",
        url: "logout.php",
        data: {},
        success: function (data) {
            location.reload();
        },
        error: function () {
        }
    });
}

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
    $("#search_submit").click(function() {
        window.location.href = "https://monistic-hotel.com/result?district=" + $("#district").val() + "&adults=" + $("#adult").html() + "&children=" + $("#child").html() + "&infants=" + $("#infant").html() + "&check_in=" + $("#start").val() +"&check_out=" + $("#end").val();
    })
});


