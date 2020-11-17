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

function sendMailVerificationRequest(email) {
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhttp.open("POST", "//gek.wz.cz/edit-profile/sendverify.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email=" + email);
}

function checkForEmailVerification(code) {
    document.getElementById("verify_email").disabled = true;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            //protože na tom úžasným hostingu je reklama, musí se na to takhle
            if(resp.indexOf("{\"response\":\"ok\"}")) {
                document.getElementById("verify_err").style.display = "none";
                $('#changeemail').modal('toggle');
                location.reload();
            }
            else {
                document.getElementById("verify_err").style.display = "block";
                document.getElementById("verify_email").disabled = false;
            }
        }
    };
    xhttp.open("POST", "//gek.wz.cz/edit-profile/checkverify.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("code=" + code);
}