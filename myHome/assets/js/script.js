$(window).on('scroll', function() {
    if ($(this).scrollTop() <= 100) {
        $('.header').removeClass('header_scroll');
        $('.btn_top').css('opacity', '0');
    } else if($(this).scrollTop() > 100) {
        $('.header').addClass('header_scroll');
        $('.btn_top').css('opacity', '1');
    }
});


/* 헤더 */
$(function() {
    //위로
    $('.btn_top').on('click', function() {
        $('html').stop().animate({scrollTop: 0}, 800);
    });

    //회원가입
    $('#join').on('click', function() {
        location.replace('join.php');
    });

    //로그인
    $('#login').on('click', function() {
        location.replace('login.php');
    });

    //로그아웃
    $('#logout').on('click', function() {
        location.replace('logout.php');
    });
});



/* 모달 */
//모달 닫기
function close_modal() {
    $('.modal').hide();

    $.each($('form'), function() { //모든 form 초기화
        this.reset();
    });
}
$('.modal .close').on('click', function() { //모달 닫기
    close_modal();
});
$(window).click(function(e) {
    var t = $(e.target); //클릭한 요소
    if (t.hasClass('modal')) {
        close_modal();
    }
});
$(window).keyup(function(e) {
    if (e.keyCode == 27) { // ESC 키를 놓았을 때
        close_modal();
    }
});

