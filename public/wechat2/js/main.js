(function () {
    if($(".repository-content").length){
        $(".repository-content .section2 ul li .line1.top .flex3").on("click",function () {
            $(this).parent().toggleClass("top").siblings(".line2").toggleClass("show");
        });
        $(".search-header .line1 .rank").on("click",function () {
            $(this).parent().siblings(".rank-list").toggleClass("show");
        });
        $(".repository-content .section3 button").on("click",function () {
            $("#dirName").val("");
            $(".repository-content .new-dir-wrap").addClass("show");
        });
        $(".repository-content .new-dir-wrap .new-dir .btn .cancel").on("click",function () {
            $(".repository-content .new-dir-wrap").removeClass("show");
        });
        $(".repository-content .section2 ul li .line2 button.key").on("click",function () {
            $("#dirPassword").val("");
            $(".repository-content .password-wrap").addClass("show");
        });
        $(".repository-content .password-wrap .password-main .btn .cancel").on("click",function () {
            $(".repository-content .password-wrap").removeClass("show");
        });
    }


    if($(".btn-switch").length){
        $(".btn-switch").on("click",function () {
            $(".footer .section2").toggleClass("show");
        })
    }
})();



