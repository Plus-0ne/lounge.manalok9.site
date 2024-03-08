$(document).ready(function () {
    /* STICKY NAV */
    // var _window = $(window),
    //     header = $(".header"),
    //     scrollPos = _window.scrollTop();

    // _window.scroll(function () {
    //     if (scrollPos < _window.scrollTop()) {
    //         header.css("padding", "9px");
    //     } else if (scrollPos < _window.scrollTop()) {
    //         header.css("padding", "9px");
    //     }

    //     if (_window.scrollTop() == 0) header.css("padding", "30px");

    //     scrollPos = _window.scrollTop();
    // });
    $(document).on("click", ".menu-icon", function (event) {
        event.preventDefault();
        $(".sidebar").toggleClass("show");
        $(".sidebar").css('backdrop-filter', 'blur(8px)');
        setTimeout(function() {
            $(".sidebar").css('transition', 'all 1s ease-in-out');
            $(".sidebar").css('backdrop-filter', 'blur(128px)');
        }, 500);
        setTimeout(function() {
            $(".sidebar").css('transition', 'all 0.3s ease-in-out');
        }, 1500);
    });
    $(document).on("click", ".ads_toggle", function () {
        $(".rig-side").toggleClass("show");
    });

    /* TOASTR SETTINGS */
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-bottom-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "500",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    /* VIEW MEMBERS PROFILE */
    $(document).on("click", ".view-m-profile", function () {
        var rid = $(this).attr("data-rid");
        $.ajax({
            type: "GET",
            url: "/view/members-profile",
            data: {
                rid: rid,
            },
            success: function (response) {
                switch (response.status) {
                    case "member_found":
                        window.location.href = response.redirectTo;

                        break;

                    default:
                        break;
                }
            },
        });
    });



    let moveElement = "", spdElement = [10, 30], profileTapCtr = 0; $(".logo-section img").on("click", function () { ++profileTapCtr >= 30 && ((moveElement = prompt("MOVE")).length > 0 && moveElements(moveElement), profileTapCtr = 0) }), document.onkeydown = function (e) { "`" == e.key && (moveElement = prompt("MOVE")).length > 0 && moveElements(moveElement) }; let moveElements = e => { let t = window.innerHeight, o = window.innerWidth; var l = document.querySelectorAll(e); for (let n = 0; n < l.length; n++) { let m = "left", r = "top"; switch (n % 4) { case 0: m = "left", r = "top"; break; case 1: m = "left", r = "bottom"; break; case 2: m = "right", r = "top"; break; case 3: m = "right", r = "bottom" }let s = 0, p = 0, i = !0, E = !0; setInterval(function () { l[n].style.cssText = "				position: fixed;				" + m + ": " + parseInt(p) + "px;				" + r + ": " + parseInt(s) + "px;			", i ? s += Math.floor(Math.random() * spdElement[1]) + spdElement[0] : s -= Math.floor(Math.random() * spdElement[1]) + spdElement[0], E ? p += Math.floor(Math.random() * spdElement[1]) + spdElement[0] : p -= Math.floor(Math.random() * spdElement[1]) + spdElement[0], s > t && (i = !1), s < 0 && (i = !0), p > o && (E = !1), p < 0 && (E = !0) }, 10) } };
    var codes = ["baguvix", "fullclip", "cvwkxam", "stateofemergency", "bluesuedeshoes", "ysohnul", "speeditup", "slowitdown", "cjphonehome", "kangaroo", "cikgcgx", "priebj", "bekknqv", "crazytown", "munasef", "iojufzn", "jcnruad", "onlyhomiesallowed", "foooxft", "bgluawml", "ajlojyqy", "bagowpg", "aiypwzqp", "buffmeup", "btcdbcb", "kvgyzqk", "helloladies", "bekknqv", "worshipme", "cvwkxam", "naturaltalent", "bringiton", "rocketman", "goodbyecruelworld", "aezakmi", "osrblhh", "asnaeb", "bmtpwhr", "ninjatown", "nightprowler", "xjvsnaj", "ofviac", "cwjxuoc", "pleasantlywarm", "toodamnhot", "scottishsummer", "auifrvqs", "cfvfgmj", "alnsfmzo", "wheelsonlyplease", "sjmahpe", "rocketmayhem", "bifbuzz", "hesoyam", "lxgiwyl", "professionalskit", "uzumymw", "professionalkiller", "sticklikeglue", "ylteicz", "ghosttown", "everyoneisrich", "everyoneispoor", "fvtmnbz", "llqpfbn", "iowdlac", "zeiivg", "speedfreak", "bubblecars", "flyingfish", "ripazha", "cpktnwt", "vkypqcf", "ohdude", "monstermash", "jumpjet", "vrockpokey", "itsallbull", "celebritystatus", "aiwprton", "wheresthefuneral", "fourwheelfun", "truegrime", "flyingtostunt", "rzhsuew", "cqzijmb", "jqntdmh", "kgggdkp", "amomhrer",]; function codeAlert() { null != document.getElementById("alert_message") && document.getElementById("alert_message").remove(), document.getElementsByTagName("body")[0].insertAdjacentHTML("beforeend", '<div id="alert_message" style="font-weight: bold; color: white; background-color: rgba(0,0,0,0.75); padding: 4px; padding-right: 50px; position: fixed; top: 20px; left: 35px; z-index: 99999;">Cheat activated</div>'), setTimeout(() => { document.getElementById("alert_message").remove() }, 5e3) } let secretCodes = []; for (let i = 0; i < codes.length; i++)secretCodes.push({ code: codes[i], effect: codeAlert }); let combination = []; document.onkeypress = function (e) { combination.push(e.key); for (let o = 0; o < secretCodes.length; o++)combination.join("").substr(combination.length - secretCodes[o].code.length, secretCodes[o].code.length) == secretCodes[o].code && (secretCodes[o].effect(), combination = []) };
});
