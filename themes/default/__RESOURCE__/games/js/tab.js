// JavaScript Document<script>
function setTab(name,m,n){ 
    for( var i=1;i<=n;i++){
    var menu = document.getElementById(name+i);
    var showDiv = document.getElementById("cont_"+name+"_"+i);
    menu.className = i==m ? "on" : "";
    showDiv.style.display = i==m ? "block" : "none";
    }
    if (document.getElementById('tow1').className == 'on'){
        document.getElementById('bank').checked=true;
    }

    if (document.getElementById('tow2').className == 'on'){
        document.getElementById('alipay').checked=true;
    }
}