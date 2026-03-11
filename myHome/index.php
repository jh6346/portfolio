<!-- 메인페이지 -->
 <?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        $(function() {
            //클론
            var housewarming_party_card = $('.housewarming_party .card').clone();
            var specialist_card = $('.specialist .card').clone();

            //슬라이드
            var slide_idx = 0;
            var slide_interval_time = 5000;
            var slide_interval;

            // //헤더
            // $(window).on('scroll', function() {
            //     console.log($(this).scrollTop());
            //     if ($(this).scrollTop() <= 100) {
            //         $('.header').removeClass('header_scroll');
            //         $('.btn_top').css('opacity', '0');
            //     } else if($(this).scrollTop() > 100) {
            //         $('.header').addClass('header_scroll');
            //         $('.btn_top').css('opacity', '1');
            //     }
            // });

            // //위로
            // $('.btn_top').on('click', function() {
            //     $('html').stop().animate({scrollTop: 0}, 800);
            // });

            //더보기
            $('.housewarming_party .more').on('click', function() {
                location.replace('housewarming_party.php');
            });
            $(document).on('click', '.specialist .more', function() {
                location.replace('specialist.php');
            });
            $('.review .more').on('click', function() {
                location.replace('specialist.php');
            });
            

            // 슬라이드 이동
            function move_slide() {
                $('.slide_wrapper').css('transform', 'translateX(-' + slide_idx * 100 + 'vw)');
                $('.bar_fill').stop().animate({width: '0%'}, 0);
                setTimeout(() => $('.bar_fill').stop().animate({width: '100%'}, 5000), 50);
            }

            // 슬라이드 자동 이동
            function auto_slide() {
                slide_interval = setInterval(() => {
                    if (slide_idx >= 2) slide_idx = 0;
                    else slide_idx++;

                    move_slide();
                }, slide_interval_time);
            }

            // 슬라이드 이전, 다음
            $('.slide>.slide_controller .prev').on('click', function() {
                if (slide_idx <= 0) slide_idx = 2;
                else slide_idx--;

                clearInterval(slide_interval);
                move_slide();
                auto_slide();
            });
            $('.slide>.slide_controller .next').on('click', function() {
                if (slide_idx >= 2) slide_idx = 0;
                else slide_idx++;

                clearInterval(slide_interval);
                move_slide();
                auto_slide();
            });

            move_slide();
            auto_slide();

            // 온라인 집들이
            $(document).on({
                mouseenter: function() {
                    $(this).find('.card_img>img').eq(1).css('right', '0');
                },
                mouseleave: function() {
                    $(this).find('.card_img>img').eq(1).css('right', '-100%');
                }
            }, '.housewarming_party .card');

            // $('.housewarming_party .card').on({
            //     mouseenter: function() {
            //         $(this).find('.card_img>img').eq(1).css('right', '0');
            //     },
            //     mouseleave: function() {
            //         $(this).find('.card_img>img').eq(1).css('right', '-100%');
            //     }
            // });

            $.ajax({
                url: 'select_housewarming_party.php',
                dataType: 'JSON',
                success: function(data) 
                {
                    $('.housewarming_party .cards').empty();
                    
                    // let clone = housewarming_party_card;

                    $.each(data, function(i, o) {
                        //새로운 복제본 만들기
                        let clone = housewarming_party_card.clone();

                        $(clone).find('.card_img>img').eq(0).attr('src', 'img/housewarming_party/' + o.before_img);

                        $(clone).find('.card_img>img').eq(1).attr('src', 'img/housewarming_party/' + o.after_img);

                        $(clone).find('.user_id').html('@' + o.user_id);

                        $(clone).find('.rating').html('<i class="fa fa-star"></i> ' + o.star);

                        $('.housewarming_party .cards').append(clone);
                        // $(clone).appendTo($('.housewarming_party .cards'));
                        
                        // clone = housewarming_party_card;
                       
                    });
                }, error: function(e) {
                    alert(e);
                }
            });

            // 전문가
            $.ajax({
                url: 'select_specialist.php',
                dataType: 'JSON',
                success: function(data) {
                    $('.specialist .cards').empty();
                    $.each(data, function(i, o) {
                        let clone = specialist_card.clone();

                        $(clone).find('.card_img>img').attr("src", "img/specialist/" + o.img);
                        $(clone).find('.name').html(o.name);

                        $('.specialist .cards').append(clone);
                    })
                }, error: function(e) {
                    console.log(e);
                }
            });


        });
    </script>
</head>
<body>
    <!-- 헤더 -->
    <?php include 'header.php'; ?>

    <!-- 위로 -->
    <div class="btn_top">
        <i class="fa fa-chevron-up"></i>
    </div>

    <!-- 슬라이드 -->
    <div class="slide">
        <div class="slide_controller">
            <h1>당신의 공간,<br>전문가와 함께 완성하세요.</h1>
            <div class="button">
                <button class="prev"><i class="fa fa-angle-left"></i></button>
                <div class="progress_bar"><div class="bar_fill"></div></div>
                <button class="next"><i class="fa fa-angle-right"></i></button>
            </div>
        </div>
        <div class="slide_wrapper">
            <img src="img/couch-1835923_1920.jpg" alt="">
            <img src="img/conference-room-768441_1920.jpg" alt="">
            <img src="img/bedroom-1006526_1920.jpg" alt="">
        </div>
    </div>

    <!-- 온라인 집들이 -->
    <div class="housewarming_party">
        <div class="section_wrapper">
            <h1>온라인 집들이</h1>
            <button class="more"><i class="fa fa-plus"> more</i></button>

            <div class="cards">

                <div class="card">
                    <div class="card_img">
                        <img src="img/housewarming_party/1_before.jpg" alt="">
                        <img src="img/housewarming_party/1_after.jpg" alt="">
                    </div>

                    <div class="card_content">
                        <div class="user_id">user1</div>
                        <div class="rating"><i class="fa fa-star"></i> 4</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 전문가 -->
    <div class="specialist">
        <div class="section_wrapper">
        <h1>전문가</h1>
        
            <div class="cards">
                
                <div class="card">
                    <div class="card_img">
                        <img src="img/specialist/specialist1.jpg" alt="">
                    </div>

                    <div class="card_content">
                        <div class="name">전문가1</div>
                        <button class="more"><i class="fa fa-plus"></i> more</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 전문가 시공 후기 -->
    <div class="review">
        <div class="section_wrapper">
            <h1>전문가 시공 후기</h1>
            <button class="more"><i class="fa fa-plus"></i> more</button>
            <div class="cards">
                <div class="card">
                    <div class="card_top">
                        <div class="specialist_name"><i class="fa fa-user"></i> 전문가2(@specialist2)</div>
                        <div class="user_name">박재현(@park)</div>
                    </div>

                    <div class="cost">
                        ₩ 3,200,000
                    </div>

                    <div class="content">
                        <i class="fa fa-quote-left"></i>원하던 아이언맨 컨셉으로 너무 잘 꾸며주셨습니다!<i class="fa fa-quote-right"></i>
                    </div>

                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="card_top">
                        <div class="specialist_name"><i class="fa fa-user"></i> 전문가4(@specialist4)</div>
                        <div class="user_name">김정수(@kim)</div>
                    </div>

                    <div class="cost">
                        ₩ 5,500,000
                    </div>

                    <div class="content">
                        <i class="fa fa-quote-left"></i>요구사항대로 부드러운 느낌을 잘 살려주셨습니다.<i class="fa fa-quote-right"></i>
                    </div>

                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 푸터 -->
    <?php include 'footer.php'; ?>
</body>
</html>