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
    if(document.querySelectorAll("#viewpass").length > 0) {
        document.querySelector("#viewpass").addEventListener("click", function() {
            let password_textbox = this.parentElement.querySelector("#password");
            if(this.checked) {
                password_textbox.setAttribute("type", "text");
            }
            else {
                password_textbox.setAttribute("type", "password");
            }
        });
    }
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
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
                if (this.readyState == 4 && this.status == 200) {
                    var resp = this.responseText;
                    resp = resp.substring(resp.indexOf("<p>"));
                    el.querySelector(".tooltiptext").innerHTML = resp;
                    el.querySelector(".tooltiptext").style.display = "block";
                }

            };
            xhttp.open("POST", "//gek.wz.cz/classes/TooltipContent.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("user_id=" + user_id);
        });
    });
}

function showEditDialog(user_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
            resp = resp.substring(resp.indexOf("{"));
            var obj = JSON.parse(resp);
            console.log(obj);
            var dialog = document.querySelector("#editUser");
            dialog.querySelector("#jmeno").value = obj.jmeno;
            dialog.querySelector("#email").value = obj.email;
            dialog.querySelector("input[name=id]").value = user_id;
            dialog.querySelectorAll("#opravneni option").forEach(function(option) {
                if(option.getAttribute("value") == obj.opravneni) {
                    option.setAttribute("selected", "selected");
                }
                else {
                    if(option.hasAttribute("selected")) {
                        option.removeAttribute("selected");
                    }
                }
            });
            $('#editUser').modal('show');
        }

    };
    xhttp.open("POST", "//gek.wz.cz/admin/users/getUserData.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("userid=" + user_id);
}