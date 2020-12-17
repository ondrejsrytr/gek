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
    document.querySelectorAll(".auto-submit").forEach(function(el) {
        el.querySelector("select").addEventListener("change", function() {
            $(el).submit();
        });
    });
    attachTooltips();
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
            if(resp.indexOf("{\"response\":\"ok\"}") >= 0) {
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

function attachTooltips() {
    document.querySelectorAll(".html-tooltip").forEach(function(el) {
        el.addEventListener("mouseenter", function(event) {
            el.querySelector(".tooltiptext").innerHTML = "";
            el.querySelector(".tooltiptext").style.display = "none";
            let user_id = el.getAttribute("data-tooltip-id");
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                var resp = this.responseText;
                resp = resp.substring(resp.indexOf("<p>"));
                el.querySelector(".tooltiptext").innerHTML = resp;
                //odstraní probliknutí, ale to ještě pak časem doladím
                setTimeout(function() {
                    el.querySelector(".tooltiptext").style.display = "block";
                }, 50);

            };
            xhttp.open("POST", "//gek.wz.cz/classes/TooltipContent.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("user_id=" + user_id);
        });
    });
}