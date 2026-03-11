<?php include 'lib.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        $(document).ready(function() {
            // slide
            var slide_text = [];
            var slide_idx = 0;
            var slide_len = 0;

            // bestseller
            var bestseller_target_category = '수험서자격증';
            var bestseller_idx = 0;

            // new book
            var newbook_target_category = 'IT매뉴얼';
            var newbook_len = 0;
            var newbook_idx = 0;

            // recommend
            var recommend_target_category = 'IT매뉴얼';
            var recommend_len = 0;
            var recommend_idx = 0;

            // header mobile
            $('.header_mobile .menu>i').on('click', function() {
                if ($('html').width() <= 800) {
                    $('.header_mobile .right_menu').css('width', ($('html').width() * 0.3) + 'px');
                } else {
                    $('.header_mobile .right_menu').css('width', '250px');
                }
            });
            $('.header_mobile .close>i').on('click', function() {
                console.log('a');
                $('.header_mobile .right_menu').css('width', '0');
            });

            $('.header_mobile .right_menu>ul>li').on('click', function() {
                $('.header_mobile .right_menu>ul>li>ul').slideUp();
                $(this).find('ul').slideDown();
            });

            // header resize
            $(window).resize(function() {
                if ($('.header_mobile .right_menu').width() > 0) {
                    if($('html').width() <= 800) {
                        $('.header_mobile .right_menu').css('width', ($('html').width() * 0.3) + 'px');
                    } else {
                        $('.header_mobile .right_menu').css('width', '250px');
                    }
                }
            });

            // resize
            $(window).resize(function() {
                // card width
                card_width = $('.book_content .card').outerWidth(true);

                card_len = $('.new_book_content').find('.card').length;
                width = card_len * card_width;
                $('.new_book_content .cards').css('width', width + 'px');

                card_len = $('.recommend_content').find('.card').length;
                width = card_len * card_width;
                $('.recommend_content .cards').css('width', width + 'px');

                // card idx
                if ($('html').width() <= 1100) {
                    newbook_idx = (newbook_len > 5) ? 5 : 0;
                    recommend_idx = (recommend_len > 5) ? 5 : 0;
                    $('.book_content .cards').css('transform', 'translateX(0)');
                }
            });

            // slide json get
            $.ajax({
                url: 'slide.json',
                method: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    slides = data.slide;
                    slide_len = slides.length;

                    $.each(slides, function(i, o) {
                        slide_text.push(o.text);
                        $(".slide_wrapper").append(
                            $('<img />', {
                                src: o.imgurl
                            })
                        );
                    });

                    $(".slide .text").html(slide_text[0]);
                    $(".slide_wrapper").css('width', slide_len + '00%');
                    $(".slide_wrapper>img").css('width', 'calc(100%/' + slide_len + ')');
                }, error: function(e) {
                    alert(e);
                }
            });

            // slide move css
            function slide_move() {
                $('.slide_wrapper').css('transform', 'translateX(-' + (100/slide_len) * slide_idx + '%)');
                $('.slide .text').html(slide_text[slide_idx]);
            }

            // slide interval
            setInterval(function() {
                if (slide_idx >= (slide_len-1)) slide_idx = 0;
                else slide_idx++;

                slide_move();
            }, 8000);

            // slide prev next
            $('.slide_right .prev').on('click', function() {
                if (slide_idx <= 0) slide_idx = slide_len-1;
                else slide_idx--;

                slide_move();
            });
            $('.slide_right .next').on('click', function() {
                if (slide_idx >= slide_len-1) slide_idx = 0;
                else slide_idx++;

                slide_move();
            });


            // bestseller
            function get_bestseller(category, idx) {
                $.ajax({
                    url: 'bestseller.json',
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        if (category == '수험서자격증') bestseller = data.bestseller[0].수험서자격증;
                        else if (category == 'IT매뉴얼') bestseller = data.bestseller[0].IT매뉴얼;
                        else if (category == '단행본') bestseller = data.bestseller[0].단행본;
                        
                        $('.bestseller_text .title').html(bestseller[idx].title);
                        $('.bestseller_text .author').html(bestseller[idx].author);
                        $('.bestseller_content>img').attr('src', bestseller[idx].imgurl);
                    }, error: function(e) {
                        alert(e);
                    }
                });
            }
            function bestseller_dot(idx) {
                $('.bestseller_content .dots>.dot').removeClass('current_dot');
                $('.bestseller_content .dots>.dot').eq(idx).addClass('current_dot');
            }

            // bestseller init
            get_bestseller('수험서자격증', bestseller_idx);
            $('.bestseller_text>h1>span').html('<i class="fa-regular fa-bookmark"></i> 수험서 자격증');

            // bestseller tab
            $('.bestseller .tab_btn').on('click', function() {
                bestseller_target_category = $(this).html().replace(/\s/gi, "");
                bestseller_idx = 0;
                get_bestseller(bestseller_target_category, bestseller_idx);
                $('.bestseller .tab_btn').removeClass('current_tab');
                $(this).addClass('current_tab');
                $('.bestseller_text>h1>span').html('<i class="fa-regular fa-bookmark"></i> ' + $(this).html());

                bestseller_dot(0);
            });

            // bestseller dot
            $('.bestseller_content .dots>.dot').on('click', function() {
                bestseller_idx = $(this).index() - 1;
                get_bestseller(bestseller_target_category, bestseller_idx);
                bestseller_dot(bestseller_idx);
            });

            // bestseller prev next
            $('.bestseller_content .dots>.prev').on('click', function() {
                if (bestseller_idx <= 0) bestseller_idx = 2;
                else bestseller_idx--;
                bestseller_dot(bestseller_idx);
                get_bestseller(bestseller_target_category, bestseller_idx);
            });
            $('.bestseller_content .dots>.next').on('click', function() {
                if (bestseller_idx >= 2) bestseller_idx = 0;
                else bestseller_idx++;
                bestseller_dot(bestseller_idx);
                get_bestseller(bestseller_target_category, bestseller_idx);
            });







            // book list (new book, recommend)
            // book list title hover
            $(document).on({
                mouseenter: function() {
                    let title_width = $(this).find('.title')[0].scrollWidth;
                    let wrapper_width = $('.book_content .title').innerWidth();
                    if (wrapper_width < title_width) {
                        let move = title_width - wrapper_width;
                        $(this).find('.title').stop().animate({marginLeft: -move}, 4000, 'linear');
                    }
                },
                mouseleave: function() {
                    $(this).find('.title').stop().animate({marginLeft: 0}, 500);
                }
            }, '.book_content .card');



            // new book
            function get_newbook(category) {
                $.ajax({
                    url: 'newbook.json',
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        $('.new_book_content .cards').empty();
                        $('.new_book_content .cards').css('transform', 'translateX(0)');
                        newbook_idx = 0;
                        newbook_len = 0;

                        if (category == 'IT매뉴얼') newbook = data.IT매뉴얼;
                        else if (category == '단행본') newbook = data.단행본;
                        else if (category == '수험서자격증') newbook = data.수험서자격증;

                        $.each(newbook, function(i, o) {
                            row = $('<div />', {
                                class: 'card'
                            }).append(
                                $('<img />', {
                                    src: o.imgurl
                                }).append(),
                                $('<div />', {
                                    class: 'card_text'
                                }).append(
                                    $('<div />', {
                                        class: 'title_wrapper'
                                    }).append(
                                        $('<p />', {
                                            class: 'title'
                                        }).append(o.title)
                                    ),
                                    $('<p />', {
                                        class: 'author'
                                    }).append(o.author),
                                    $('<p />', {
                                        class: 'price'
                                    }).append('&#8361;' + o.price)
                                )
                            );

                            $('.new_book_content .cards').append(row);
                            newbook_len++;
                        });

                        newbook_idx = (newbook_len > 5) ? 5 : 0;
                        card_width = $('.book_content .card').outerWidth(true);
                        card_len = $('.new_book_content').find('.card').length;
                        width = card_len * card_width;
                        $('.new_book_content .cards').css('width', width + 'px');
                    }, error: function(e) {
                        alert(e);
                    }
                });
            }
            // new book prev next
            $('.new_book .next').on('click', function() {
                if ((newbook_len > 5) && (newbook_idx < newbook_len)) {
                    newbook_idx++;
                    let width = 200;
                    $('.new_book_content .cards').css('transform', 'translateX(-' + (width * (newbook_idx - 5)) + 'px)');
                }
            });

            $('.new_book .prev').on('click', function() {
                if (newbook_idx > 5) {
                    newbook_idx--;
                    let width = 200;
                    $('.new_book_content .cards').css('transform', 'translateX(-' + (width * (newbook_idx - 5)) + 'px)');
                }
            });

            // new book init
            get_newbook(newbook_target_category);
            
            // new book tab
            $('.new_book_content .tab_btn').on('click', function() {
                newbook_target_category = $(this).html().replace(/\s/gi, "");
                get_newbook(newbook_target_category);
                $('.new_book_content .tab_btn').removeClass('current_tab');
                $(this).addClass('current_tab');
            });



            
            // recommend
            function get_recommend(category) {
                $.ajax({
                    url: 'recommend.json',
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        $('.recommend_content .cards').empty();
                        $('.recommend_content .cards').css('transform', 'translateX(0)');
                        recommend_idx = 0;
                        recommend_len = 0;

                        if (category == 'IT매뉴얼') recommend = data.IT매뉴얼;
                        else if (category == '단행본') recommend = data.단행본;
                        else if (category == '수험서자격증') recommend = data.수험서자격증;

                        $.each(recommend, function(i, o) {
                            row = $('<div />', {
                                class: 'card'
                            }).append(
                                $('<img />', {
                                    src: o.imgurl
                                }).append(),
                                $('<div />', {
                                    class: 'card_text'
                                }).append(
                                    $('<div />', {
                                        class: 'title_wrapper'
                                    }).append(
                                        $('<p />', {
                                            class: 'title'
                                        }).append(o.title)
                                    ),
                                    $('<p />', {
                                        class: 'author'
                                    }).append(o.author),
                                    $('<p />', {
                                        class: 'price'
                                    }).append('&#8361;' + o.price)
                                )
                            );

                            $('.recommend_content .cards').append(row);
                            recommend_len++;
                        });

                        recommend_idx = (recommend_len > 5) ? 5 : 0;

                        card_width = $('.book_content .card').outerWidth(true);
                        card_len = $('.recommend_content').find('.card').length;
                        width = card_len * card_width;
                        $('.recommend_content .cards').css('width', width + 'px');
                    }, error: function(e) {
                        alert(e);
                    }
                });
            }

            // recommend init
            get_recommend(recommend_target_category);
            
            // recommend tab
            $('.recommend_content .tab_btn').on('click', function() {
                recommend_target_category = $(this).html().replace(/\s/gi, "");
                get_recommend(recommend_target_category);
                $('.recommend_content .tab_btn').removeClass('current_tab');
                $(this).addClass('current_tab');
            });

            // recommend prev next
            $('.recommend .next').on('click', function() {
                if ((recommend_len > 5) && (recommend_idx < recommend_len)) {
                    recommend_idx++;
                    let width = 200;
                    $('.recommend_content .cards').css('transform', 'translateX(-' + (width * (recommend_idx - 5)) + 'px)');
                }
            });

            $('.recommend .prev').on('click', function() {
                if (recommend_idx > 5) {
                    recommend_idx--;
                    let width = 200;
                    $('.recommend_content .cards').css('transform', 'translateX(-' + (width * (recommend_idx - 5)) + 'px)');
                }
            });

        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="content">
        <!-- masthead -->
        <div class="masthead">
            <div class="slide">
                <div class="slides">
                    <div class="slide_wrapper">
                    </div>
                </div>

                <div class="slide_right">
                    <div class="middle">
                        <p class="text"></p>
                        <button class="buy btn_green"><span>도서구매<i class="fa-solid fa-angles-right"></i></span></button>
                    </div>
                    <button class="prev btn"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="next btn"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        </div>


        <!-- bestseller -->
        <div class="bestseller">
            <div class="tab">
                <button class="current_tab tab_btn">수험서 자격증</button>|<button class="tab_btn">IT 매뉴얼</button>|<button class="tab_btn">단행본</button>
            </div>

            <div class="bestseller_content">
                <div class="dots">
                    <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
                    <div class="dot current_dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
                </div>

                <div class="bestseller_text">
                    <h1>베스트셀러<span><i class="fa-solid fa-bookmark"></i></span></h1>
                    <span class="more"><i class="fa-solid fa-plus"></i>more</span>
                    <p class="title">2026 이기적 한식조리기능사 필기 이론+기출문제</p>
                    <p class="author">최경선</p>
                    <button class="info btn_green"><span>도서정보<i class="fa-solid fa-angles-right"></i></span></button>
                </div>

                <img src="" alt="">
            </div>
        </div>


        <!-- new book -->
        <div class="new_book book_list">
            <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
            
            <div class="new_book_content book_content">
                <h1><span>신간</span> 도서</h1>
                <div class="tab">
                    <button class="current_tab tab_btn">IT 매뉴얼</button>|<button class="tab_btn">단행본</button>|<button class="tab_btn">수험서 자격증</button>
                </div>
                <div class="cards_wrapper">
                    <div class="cards">
                        <!-- <div class="card">
                            <img src="img/youngjin/newbook/9788931479003.jpg" alt="">
                            <div class="card_text">
                                <p class="title">마인크래프트 건축가이드: 마법 프로젝트</p>
                                <p class="author">mojang AB</p>
                                <p class="price">\14,000</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>


        <!-- recommend -->
        <div class="recommend book_list">
            <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
            
            <div class="recommend_content book_content">
                <h1><span>추천</span> 도서</h1>
                <div class="tab">
                    <button class="current_tab tab_btn">IT 매뉴얼</button>|<button class="tab_btn">단행본</button>|<button class="tab_btn">수험서 자격증</button>
                </div>
                <div class="cards_wrapper">
                    <div class="cards">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>