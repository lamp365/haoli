$(function () {
    resize();
    $(window).resize(resize);
    function resize() {
        if ($(window).width() > 550) {
            $.nyroModalSettings({type: 'iframe', minHeight: 440, minWidth: 550, titleFromIframe: true, modal: true})
        } else {
            $.nyroModalSettings({type: 'iframe', minHeight: 500, minWidth: 550, titleFromIframe: true, modal: true});
        }
    }


});


function check_is_pay(url,gourl,orderid){
    var intval = setInterval(function(){
        if(orderid == undefined || orderid == ''){
            orderid = 0;
        }
        $.post(url,{orderid:orderid},function(data){
            if(data.data.status == 1){
                top.location.href = gourl;
            }
        },'json');
    },2000);
}

