$(function(){
    $(".sidebar_menu > li.have_children > a").on("click", function(i){
        i.preventDefault();
        if( ! $(this).parent().hasClass("active") ){
            $(".sidebar_menu li ul").slideUp();
            $(this).next().slideToggle();
            $(".sidebar_menu li").removeClass("active");
            $(this).parent().addClass("active");
        }
        else{
            $(this).next().slideToggle();
            $(".sidebar_menu li").removeClass("active");
        }
    });
    $('.nav_toggle').click(function(){
            $(this).toggleClass('active');
            $(this).next('.sidebar_wrap').toggleClass('active')
        }
    );
});
