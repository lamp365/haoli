/**
 * Created by kevin on 16-10-11.
 */
function tip(msg,type,time){
    type = type=='' ? 'success' : type;
    type = type=='' ? '' : type;
    var div = $("#poptip");
    var content =$("#poptip_content");
    if(div.length<=0){
        div = $("<div id='poptip'></div>").appendTo(document.body);
        if(type!='success' && type!='danger'){
            type = 'success';
        }
        content =$("<div id='poptip_content' class='tip_"+type+"'>" + msg + "</div>").appendTo(document.body);
    }else{
        content.html(msg);
        content.show();
        div.show();
    }
    $(window).scrollTop(0);
    if(time) {
        time =  isNaN(time)? '2000' : time;
        setTimeout(function(){
            content.fadeOut(500);
            div.fadeOut(500);

        },time);
    }
}
function tip_close(){
    $("#poptip").fadeOut(500);
    $("#poptip_content").fadeOut(500);
}

$(function(){
    $("#myModal").on("hidden.bs.modal", function() {
        $(this).removeData("bs.modal");
    })
})