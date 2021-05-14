        $(".delete").on('click', function (e) {
            Swal.fire({
                title: 'Are you sure to delete this accommodation?',
                showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes'
            }).then((result) => {
                 if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "delete_host.php",
                        data: {accommodation_id: $(this).closest("tr").attr("id")},
                        success: function (data) {
                            location.reload();
                        },
                        error: function () {
                        }
                    });
                }
            })
        });
        
        var e_amenities = $('#e_amenities').selectize();
        var e_rules = $('#e_rules').selectize();
        var amenities = $('#amenities').selectize();
        var rules = $('#rules').selectize();
        var e_district = $('#e_district').selectize();
        $('#district').selectize();
        
        var e_content = [];
        var e_config = [];
        
        $("#image").fileinput({
            uploadUrl : '#',
            showUpload: false,
            autoReplace: false,
            maxFileCount: 6,
            showClose: false,
            showZoom: false,
            showRemove: true,
            dropZoneEnabled: false,
            overwriteInitial: false,
            allowedFileExtensions: ['jpg','png','jpeg']
        }).on('fileselect', function(event, numFiles, label) {

        }).on('filecleared', function(event) {

        });
        
        $("#e_image").fileinput({
            uploadUrl : '#',
            showUpload: false,
            autoReplace: true,
            showClose: false,
            showZoom: false,
            showRemove: true,
            dropZoneEnabled: false,
            allowedFileExtensions: ['jpg','png','jpeg'],
            //showAjaxErrorDetails: false, 
            msgPlaceholder: "The new one will overwrite the old one",
            //initialPreview: e_content,
            //initialPreviewConfig: e_config,
            //removeFromPreviewOnError: true
        }).on('fileclear', function(event) {
            console.log("fileclear");
        }).on('filepredelete', function(event, key, jqXHR, data) {
            console.log(event);
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

        $(".edit").on('click', function (e) {
            $.ajax({
                type: "POST",
                url: "search_host.php",
                data: {accommodation_id: $(this).closest("tr").attr("id")},
                success: function (data) {
                    var objJSON = JSON.parse(data);
                    $("#e_room_name").val(objJSON["room_name"]);
                    $("#o_room_name").val(objJSON["room_name"]);
                    $("#e_room_desc").val(objJSON["room_desc"]);
                    $("#e_price").val(objJSON["price"]);
                    $("#e_room_livestyle").val(objJSON["room_livestyle"]);
                    $("#e_no_of_room").val(objJSON["no_of_room"]);
                    $("#e_no_of_bathroom").val(objJSON["no_of_bathroom"]);
                    $("#e_max_of_people").val(objJSON["max_of_people"]);
                    $("#e_single_bed").val(objJSON["single_bed"]);
                    $("#e_double_bed").val(objJSON["double_bed"]);
                    $("#e_location").val(objJSON["location"]);
                    $("#e_checkin_time").val(objJSON["check_in"]);
                    $("#e_checkout_time").val(objJSON["check_out"]);
                    
                    e_district[0].selectize.setValue(objJSON["district"]);
                    
                    const amenity = objJSON["amenities"].split(",");
                    e_amenities[0].selectize.setValue(amenity);
                    
                    const rule = objJSON["rules"].split(",");
                    e_rules[0].selectize.setValue(rule);

                    /*for (let i=0; i<objJSON["files"].length; i++) {
                        e_content.push("<img class='file-preview-image kv-preview-data' src='https://monistic-hotel.com/" + objJSON["files"][i] + "'>");
                        e_config.push({url: '/delete_img.php', key:i});
                    }
                    
                    $("#e_image").fileinput('destroy');
                    */
                },
                error: function () {
                }
            });
        });
        
        $("#checkin_time").bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: "HH:mm",
            clearButton: true,
        }).on("change", function(e, date) {
        });
        
        $("#checkout_time").bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: "HH:mm",
            clearButton: true,
        }).on("change", function(e, date) {
        });
        
        $("#e_checkin_time").bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: "HH:mm",
            clearButton: true,
        }).on("change", function(e, date) {
        });
        
        $("#e_checkout_time").bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: "HH:mm",
            clearButton: true,
        }).on("change", function(e, date) {
        });
        
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
            $("#login_button").click(function () {
                document.body.classList.add("stop-scrolling");
            });
            $(".lw-overlay").click(function () {
                document.body.classList.remove("stop-scrolling");
            });
            $(".lw-close").click(function () {
                document.body.classList.remove("stop-scrolling");
            });
        });
