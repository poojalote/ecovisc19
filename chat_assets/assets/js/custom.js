$(document).ready(function() {

    $(".e1").click(function(event){
        var client = $('.chat.active-chat').attr('client');

        var prevMsg = $('#chatFrom .chatboxtextarea').val();
        var shortname = $(this).data('shortname');

        $('#chatFrom .chatboxtextarea').val(prevMsg+' '+shortname+' ');
        //$('#chatFrom .chatboxtextarea').focus();
    });
    $(".chat-head .personName").click(function(){
        var personName = $(this).text();
    });



    $("#launchProfile").click(function(){
        var UserId = $('#chat_open_user_id').val();
        var profile_image = $('#userImage').html();
        
        //alert(UserId);
        $("#userProfile").html('<div class="preloader"><div class="cssload-speeding-wheel"></div></div>');

        var usname = $(this).find('img').attr('alt');

        var usname = $('.right .top').attr("data-user");
        var img = $('.right .top').attr("data-image");

        $('#wchat .wchat').removeClass('two');
        $('#wchat .wchat').addClass('three');
        $('.wchat-three').slideDown(50);
        $('.wchat-three').toggleClass("shw-rside");

        var profileTpl = '<div class="">' +
            '<div class="user-bg">' +
            '<div class="overlay-box">' +
            '<div class="user-content"> <a href="javascript:void(0)">' +
            ''+profile_image+'</a><span id="image_data"></span>' +
            '<h4 class="text-white">'+usname+' <span id="edit_data"></span></h4>' +
            '<div class="col-sm-offset-1 col-sm-10" id="group_input" style="display:none;"><input type="text" class="col-sm-8" name="group_name" value="'+usname+'" id="grp_name"> <button class="btn btn-info col-sm-4" onclick="update_grpName('+UserId+')" style="margin-top: 1px;padding: 8px"><i class="fas fa-sign-out-alt"></i></button></div>' +
            '</div>' +
            '<div class="col-sm-offset-1 col-sm-10" id="group_Image" style="display:none;"><form id="grpForm"><div class="col-sm-8"><input type="file" class="form-control" name="grp_image[]" id="grp_image"><input type="hidden" name="grpID" id="grpID" value="'+UserId+'"></div><div class="col-sm-4"> <a class="btn btn-info form-control" onclick="update_grpImage('+UserId+')" style="margin-top: 1px;padding: 8px"><i class="fas fa-sign-out-alt"></i></a></div></form></div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="">' +
            '<div class="row text-center m-t-10">' +
            '<div class="col-md-12 b-r" id="data3"></div>' +
            '</div>' +
            '<hr>' +
            '<div class="row text-center m-t-10">' +
            '<div class="col-md-12 b-r" id="data1"></div>' +
            '</div>' +
            '<hr>' +
            '<div class="col-md-12 b-r" id="data5"></div>' +
            '</div>' +
            '<div class="col-md-1 col-sm-1 text-center">&nbsp;</div>' +
            '</div>' +
            '</div>';
        $.ajax({
            type: "POST",
            url: base_url + "Chat_Controller_Test/get_member",

            data: {id:UserId},
            success: function (result) {

                console.log(result);
                result1 = JSON.parse(result);
                if (result1.status == 200) {
                    // alert(result1.body);
                    $('#image_data').html(result1.data6);
                    $('#edit_data').html(result1.data4);
                    $('#data3').html(result1.data3);
                    $('#data1').html(result1.data1);
                    $('#group_mem').html(result1.data);
                    $('#data5').html(result1.data5);


                }else {
                    $('#group_mem').html("");
                    // alert(result1.body);

                }
            },
            error: function (error) {
                console.log(error);
                alert("something went to wrong");
            }
        });

        $("#userProfile").html(profileTpl);
    });

    $(".header-close").click(function(){
        $('#wchat .wchat').removeClass('three');
        $('#wchat .wchat').addClass('two');
        $('.wchat-three').css({'display':'none'});

    });

    $(".scroll-down").click(function(){
        scrollDown();
    });

    $("#mute-sound").click(function(){
        if(eval(localStorage.sound)){
            localStorage.sound = false;
            $("#mute-sound").html('<i class="icon icon-volume-off"></i>');
        }
        else{
            localStorage.sound = true;
            $("#mute-sound").html('<i class="icon icon-volume-2"></i>');
            audiomp3.play();
            audioogg.play();
        }
    });
    $("#MobileChromeplaysound").click(function(){
        if(eval(localStorage.sound)){
            audiomp3.play();
            audioogg.play();
        }
    });
    if(eval(localStorage.sound)){
        $("#mute-sound").html('<i class="icon icon-volume-2"></i>');
    }
    else{
        $("#mute-sound").html('<i class="icon icon-volume-off"></i>');
    }

    //For Mobile on keyboard show/hide

    /*var _originalSize = $(window).width() + $(window).height()
    $(window).resize(function(){
        if($(window).width() + $(window).height() != _originalSize){
            //alert("keyboard show up");
            $(".target-emoji").css({'display':'none'});
            $('.wchat-filler').css({'height':0+'px'});

        }else{
            //alert("keyboard closed");
            $('#chatFrom .chatboxtextarea').blur();
        }
    });*/
});

function cancelFile() {
    $('#uploadImageFile').val('');
    $('#uploadDocFile').val('')
    if ($(".target-preview").css('display') == 'block') {
        $(".target-preview").slideToggle();
    }
    $('#isFiles').val(0);
}

function fileUpload(type) {

    if(type == 1){
        $('#uploadImageFile').click();
    }else{
        $('#uploadDocFile').click();
    }

}
function readURL(input) {

    if (input.files && input.files[0]) {
        var file = input.files[0];

        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}


function chatPreview(type,a) {
    $('#isFiles').val(1);
    if(type == 1){
        readURL(a);
    }else{

    }
    if ($(".target-preview").css('display') == 'none') {
        $(".target-preview").slideToggle('fast', function () {

            if ($(".target-preview").css('display') == 'block') {

                //alert($(window).height());
                //$('.chat-list').css({'height':(($(window).height())-279)+'px'});
                $('.wchat-filler').css({'height': 225 + 'px'});
                //  $('.btn-emoji').removeClass('ti-face-smile').addClass('ti-arrow-circle-down');
            } else {
                //$('.chat-list').css({'height':(($(window).height())-179)+'px'});
                $('.wchat-filler').css({'height': 0 + 'px'});
                //$('.btn-emoji').removeClass('ti-arrow-circle-down').addClass('ti-face-smile');
            }
        });
        var heit = $('#resultchat').css('max-height');
    }
}

function chatemoji() {
    $(".target-emoji").slideToggle( 'fast', function(){

        if ($(".target-emoji").css('display') == 'block') {
            //alert($(window).height());
            //$('.chat-list').css({'height':(($(window).height())-279)+'px'});
            $('.wchat-filler').css({'height':225+'px'});
            $('.btn-emoji').removeClass('ti-face-smile').addClass('ti-arrow-circle-down');
        } else {
            //$('.chat-list').css({'height':(($(window).height())-179)+'px'});
            $('.wchat-filler').css({'height':0+'px'});
            $('.btn-emoji').removeClass('ti-arrow-circle-down').addClass('ti-face-smile');
        }
    });
    var heit = $('#resultchat').css('max-height');
}

function typePlace() {

    if(!$('#textarea').html() == '')
    {
        $(".input-placeholder").css({'visibility':'hidden'});
    }
    else{
        $(".input-placeholder").css({'visibility':'visible'});
    }

}



//Inbox User search
$(document).ready(function(){
    $('.contact-list li').each(function(){
        $(this).attr('data-search-term', $(this).text().toLowerCase());
    });

    $('.live-search-box').on('keyup', function(){
        var searchTerm = $(this).val().toLowerCase();
        $('.live-search-list li').each(function(){

            if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

$(window).bind("load", function() {
    //$('.person:first').trigger('click');
    var personName = $('.person:first').find('.personName').text();
    $('.right .top .personName').html(personName);
    //$('.right .top').attr("data-user",personName);
    var userImage = $('.person:first').find('.userimage').html();
    $('.right .top .userimage').html(userImage);
    var personStatus = $('.person:first').find('.personStatus').html();
    $('.right .top .personStatus').html(personStatus);
    var hideContent = $('.person:first').find('.hidecontent').html();
    $('.right .hidecontent').html(hideContent);

    /*$('[contenteditable]').on('paste',function(e) {
        e.preventDefault();
        var text = (e.originalEvent || e).clipboardData.getData('text/plain')
        document.execCommand('insertText', false, text);
    });
*/
    $('.chatboxtextarea').on('focus',function(e) {
        $(".target-emoji").css({'display':'none'});
        $('.wchat-filler').css({'height':0+'px'});
    });
});


$('.left .person').mousedown(function(){
    if ($(this).hasClass('.active')) {
        return false;
    } else {
        var findChat = $(this).attr('data-chat');
        var personName = $(this).find('.personName').text();
        $('.right .top .personName').html(personName);
        //$('.right .top').attr("data-user",personName);
        var userImage = $(this).find('.userimage').html();
        $('.right .top .userimage').html(userImage);
        var personStatus = $(this).find('.personStatus').html();
        $('.right .top .personStatus').html(personStatus);
        var hideContent = $(this).find('.hidecontent').html();
        $('.right .hidecontent').html(hideContent);
        $('.chat').removeClass('active-chat');
        $('.left .person').removeClass('active');
        $(this).addClass('active');
        $('.chat[data-chat = '+findChat+']').addClass('active-chat');
    }
});


