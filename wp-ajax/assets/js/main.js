; (function ($) {
    $(document).ready(function () {
        $(".action-button").on('click', function () {
            let task = $(this).data('task');
            //() aita er modde data-task er function call hoibe
            window[task]();
        });
    });
})(jQuery);
function simple_ajax_call(){
let $ = jQuery;
let name=prompt("What is Your Name?");
$.post(plugindata.ajax_url,{'action':'ajd_simple','data':name},function (data){
    $("#plugin-demo-result").html("<pre>" + data + "</pre>").show();
})
}
function unp_ajax_call(){
    let $ = jQuery;
    let name=prompt("what is your country?");
    $.post(plugindata.ajax_url,{'action':'unp_simple','data':name},function (data){
        $("#plugin-demo-result").html("<pre>" + data + "</pre>").show();
    });
}

function ajd_localize_script(){
    let $=jQuery;

    $.post(plugindata.ajax_url,{'action':"local_data",'data':baket},function (data){
        $("#plugin-demo-result").html("<pre>" + data + "</pre>").show();
    })
}

function ajd_secure_ajax_call(){
    let $=jQuery;
    $.post(plugindata.ajax_url,{'action':"ajd_protected","security":"hallo bangladesh","ajd_nonce":plugindata.ajd_nonce},function (data){
        $("#plugin-demo-result").html("<pre>" + data + "</pre>").show();
    })
}

