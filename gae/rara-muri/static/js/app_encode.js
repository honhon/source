$(function(){
    var char_set = "";

    var clear = function(){
        $('#result').html("");
        progress(false);
    };
    var progress = function(bln){
        if(bln){
            $('#progress').show();
        }else{
            $('#progress').hide();
        }
    };
    var query = function(act){
        if($("#request_text").val() == ""){
            $('#result').html('<div class="alert alert-danger">テキストを入力してください</div>');
            return;
        }
        progress(true);
        $.ajax({url:    '/encode/query/'
            , type:     'post'
            , data:     {'act':act, 'request_text': $("#request_text").val(), 'char_set':char_set}
            , timeout:  10000
            , async:    true
            , error:    function(r, s, e){
                clear();
                $('#result').html('<div class="alert alert-danger">' + r.status + " : " + s + "<br>" +  e.message + '</div>');
            }
            , success:  function(res){
                clear();
                $("#result").html('<div class="well">' + res + '</div>');
            }
        });
    };

    /* set menu */
    $("div#tab_list a").click(function(){
        clear();
        $("div#tab_list a").each(function(){
            $(this).removeClass("active");
        });
        $(this).addClass("active");
    });

    /* set charset(urlencode) */
    $("div#char_set button").click(function(){
        char_set = $(this).val();
        $("div#char_set button").each(function(){
            $(this).removeClass("active");
        });
        $(this).addClass("active");
        return false;
    });

    /* clear when text have changed */
    $("#request_text").keyup(function(){
         clear();
    });

    $('#btn_urlencode').click(    function(){ query('url_enc');    });
    $('#btn_urldecode').click(    function(){ query('url_dec');    });
    $('#btn_base64_encode').click(function(){ query('base64_enc'); });
    $('#btn_base64_decode').click(function(){ query('base64_dec'); });
    $('#btn_md5').click(          function(){ query('md5');        });
    $('#btn_sha1').click(         function(){ query('sha1');       });

    /* window.onload */
    $("#char_set button:first-child").trigger("click");
    $("#tab_list a:first-child").trigger("click");
});
