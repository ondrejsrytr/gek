//hack na odstranění otravné reklamy hostingu
//PS: neříkejte jim to, jinak nám to smažou :-)
window.addEventListener("load", function() {
    document.querySelectorAll("div[style]").forEach(function (el) {
        //clear:both;width:100%;height:90px;padding:0px;z-index:99;position:relative;
        if(el.style.clear == "both" && el.style.width == "100%" && el.style.height == "90px" && el.style.zIndex == "99") {
            el.remove();
        }
    });
    document.querySelectorAll("iframe").forEach(function (el) {
        el.remove();
    });
});
