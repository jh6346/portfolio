$(document).ready(function() {
    // product clone
    var product = $('.product-grid:nth-child(1)').clone();

    // shop
    var shop_arr = [];
    var shop_tr = $('.table>tbody>tr').clone();
    
    // li category
    $.ajax({
        url: 'music_data.json',
        dataType: 'JSON',
        success: function(data) {
            let set = new Set();

            $.each(data.data, function(i, o) {
                set.add(o.category);
            });

            for (category of set) {
                if (category != '발라드') {
                    let clone_nav = $('.navbar-side .nav>li:nth-child(3)').clone();
                    $(clone_nav).find('span').html(category);
                    $('.navbar-side .nav').append(clone_nav);
                }    
            }
        }, error: function(e) {
            alert(e);
        }
    });

    
    var setCookie = function(name, value, exp) {
        var date = new Date();
        date.setTime(date.getTime() + exp*24*60*60*1000);
        document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
    }

    var getCookie = function(name) {
        var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return value ? value[2] : null;
    }

    //쿠키 가져오기
    if (JSON.parse(getCookie('shop_arr')) == null)
        shop_arr = [];
    else
        shop_arr = JSON.parse(getCookie('shop_arr'));


    // 카테고리 전체
    function all() {
        $.ajax({
            url: 'music_data.json',
            dataType: 'JSON',
            success: function(data) {
                let clone_product = $(product).clone();
                $('.contents').empty();

                data.data.sort(function(a, b) {
                    return a.release > b.release ? -1 : a.release < b.release ? 1 : 0;
                });

                $.each(data.data, function(i, o) {
                    $(clone_product).find('.img-responsive').attr('src', 'images/' + o.albumJaketImage);

                    $(clone_product).find('.produ-cost>h5').text(o.albumName);
                    $(clone_product).find('.produ-cost>span').eq(0).children('p').text(o.artist);
                    $(clone_product).find('.produ-cost>span').eq(1).children('p').text(o.release);

                    price = parseInt(o.price.replace(/[^-0-9]/g, ''));
                    $(clone_product).find('.produ-cost>span').eq(2).children('p').text(price.toLocaleString() + '원');
                    
                    $(clone_product).appendTo('.contents');
                    clone_product = $(product).clone();
                });

                $('.col-md-12>h2').html('ALL');
                shopcart_btn();
            }, error: function(e) {
                alert(e);
            }
        });
    }
    
    // 카테고리
    function get_category(category) {
        $.ajax({
            url: 'music_data.json',
            dataType: 'JSON',
            success: function(data) {
                let clone_product = $(product).clone();
                $('.contents').empty();

                data.data.sort(function(a, b) {
                    return a.release > b.release ? -1 : a.release < b.release ? 1 : 0;
                });

                $.each(data.data, function(i, o) {
                    if (o.category == category) {
                        $(clone_product).find('.img-responsive').attr('src', 'images/' + o.albumJaketImage);

                        $(clone_product).find('.produ-cost>h5').text(o.albumName);
                        $(clone_product).find('.produ-cost>span').eq(0).children('p').text(o.artist);
                        $(clone_product).find('.produ-cost>span').eq(1).children('p').text(o.release);

                        price = parseInt(o.price.replace(/[^-0-9]/g, ''));
                        $(clone_product).find('.produ-cost>span').eq(2).children('p').text(price.toLocaleString() + '원');
                        
                        $(clone_product).appendTo('.contents');
                        clone_product = $(product).clone();
                    }

                    $('.col-md-12>h2').html(category);
                    shopcart_btn();
                });
            }, error: function(e) {
                alert(e);
            }
        });
    }

    // nav click
    $(document).on('click', '.navbar-side .nav>li>a', function() {
        category = $(this).find('span').html();

        if (category == 'ALL') {
            all();
        } else if (category.indexOf('&amp;') != -1) {
            get_category($(this).find('span').html().replace('&amp;', '&'));
        } else if (category != '') {
            get_category($(this).find('span').html());
        }
    });


    // 검색
    function search (keyword) {
        $.ajax({
            url: 'music_data.json',
            dataType: 'JSON',
            success: function(data) {
                let count = 0;
                
                data.data.sort(function(a, b) {
                    return a.release > b.release ? -1 : a.release < b.release ? 1 : 0;
                });
                
                $.each(data.data, function(i, o) {
                    if ((o.albumName.indexOf(keyword) != -1) || (o.artist.indexOf(keyword) != -1)) {
                        let clone_product = $(product).clone();
                        let regex = new RegExp(keyword, 'gi');

                        // album jaket img
                        $(clone_product).find('.img-responsive').attr('src', 'images/' + o.albumJaketImage);

                        // album name
                        $(clone_product).find('.produ-cost>h5').text(o.albumName);

                        $(clone_product).find('.produ-cost>h5:contains(' + keyword + ')').each(function() {
                            $(this).html($(this).text().replace(regex, '<span>' + keyword + '</span>'));
                        });

                        $(clone_product).find('.produ-cost>h5>span').css({
                            'display' : 'inline',
                            'background-color' : 'yellow'
                        });

                        // artist
                        $(clone_product).find('.produ-cost>span').eq(0).children('p').text(o.artist);

                        $(clone_product).find('.produ-cost>span').eq(0).children('p:contains(' + keyword + ')').each(function() {
                            $(this).html($(this).text().replace(regex, '<span>' + keyword + '</span>'));
                        });

                        $(clone_product).find('.produ-cost>span').eq(0).children('p').children('span').css({
                            'display' : 'inline',
                            'background-color' : 'yellow'
                        });

                        // release
                        $(clone_product).find('.produ-cost>span').eq(1).children('p').text(o.release);

                        //price
                        price = parseInt(o.price.replace(/[^-0-9]/g, ''));
                        $(clone_product).find('.produ-cost>span').eq(2).children('p').text(price.toLocaleString() + '원');
                        
                        //append
                        $(clone_product).appendTo('.contents');
                        shopcart_btn();
                        count++;
                    }
                });
                
                if (!count) {
                    $('.contents').append('검색된 앨범이 없습니다.');
                }

                $('.search .form-control').val('');
            }, error: function(e) {
                alert(e);
            }
        });
    }

    $('.search .btn').on('click', function() {
        let keyword = $('.search .form-control').val();
        $('.contents').empty();

        if (keyword != '')
            search(keyword);
        else
            $('.contents').append('검색된 앨범이 없습니다.');
    });

    $('.search .form-control').keydown(function(key) {
        if (key.keyCode == 13) {
            let keyword = $('.search .form-control').val();
            $('.contents').empty();

            if (keyword != '')
                search(keyword);
            else
                $('.contents').append('검색된 앨범이 없습니다.');
            }
    });

    // 쇼핑카트 get
    function get_shop() {
        let tr = $(shop_tr).clone();
        let total_price = 0;
        let total_num = 0;
        $('#myModal tbody').empty();

        for (i of shop_arr) {
            // img
            $(tr).find('.albuminfo>img').attr('src', 'images/' + i.albumJaketImage);

            // album name
            $(tr).find('.info>h4').html(i.albumName);

            // artist
            $(tr).find('.info>span').eq(0).children('p').html(i.artist);

            // release
            $(tr).find('.info>span').eq(1).children('p').html(i.release);

            // price
            price = parseInt(i.price.replace(/[^-0-9]/g, ''));

            $(tr).find('.albumprice').html('&#8361; ' + price.toLocaleString());
            $(tr).find('.albumqty').children('input').val(i.len);

            $(tr).find('.pricesum').html('&#8361; ' + (price * i.len).toLocaleString());

            // append
            $('#myModal tbody').append(tr);

            tr = $(shop_tr).clone();

            total_num += parseInt(i.len);
            total_price += parseInt(price * i.len);
        }

        $('.totalprice>h3>span').html(total_price.toLocaleString());

        $('.navbar .panel-body .btn-primary').html('<i class="fa fa-shopping-cart"></i> 쇼핑카트 <strong>' + total_num +'</strong> 개 금액 ￦ ' + total_price.toLocaleString() + '원</a> ');
    }

    // 추가
    function shop_add(o) {
        let num = 0;

        for (i of shop_arr) {
            if ((o.albumName == i.albumName) && (o.artist == i.artist)) {
                i.len++;
                num = i.len;
            }
        }
        if (!num) {
            o.len = 1;
            shop_arr.push(o);
        }
        get_shop();
    }

    // 삭제
    function shop_del(title, artist) {
        rs = confirm('정말 삭제 하시겠습니까?');

        if (rs) {
            $.each(shop_arr, function(i, o) {
                if ((o.albumName == title) && (o.artist == artist)) {
                    shop_arr[i]['len'] = 0;
                    shopcart_btn();

                    shop_arr.splice(i, 1);

                    get_shop();
                    return false; //break
                }
            });
            return 1;
        } else {
            return 0;
        }
    }

    // 삭제 버튼
    $(document).on('click', '#myModal tbody .btn', function() {
        title = $(this).parents('tr').find('.info>h4').html();
        artist = $(this).parents('tr').find('.info>span').eq(0).children('p').html();
        shop_del(title, artist);
    });
    

    // 쇼핑카트 담기
    $(document).on('click', '.shopbtn', function() {
        albumName = $(this).parent('.produ-cost').children('h5').html();
        artist = $(this).parent('.produ-cost').children('span').eq(0).find('p').html();

        
        let target_btn = $(this);

        $.ajax({
            url: 'music_data.json',
            dataType: 'JSON',
            success: function(data) {
                $.each(data.data, function(i, o) {
                    if ((o.albumName == albumName) && (o.artist == artist)) {
                        shop_add(o);
                    }
                });

                $.each(shop_arr, function(i, o) {
                    if ((o.albumName == albumName) && (o.artist == artist)) {
                        $(target_btn).children('button').html('<i class="fa fa-shopping-cart"></i> 추가하기 (' + shop_arr[i]['len'] + '개)');
                    }
                });
            }, error: function(e) {
                alert(e);
            }
        });
    });
    
    // albumqty input number 바뀌었을때
    $(document).on('change', '.albumqty>input', function() {
        num = $(this).val();

        title = $(this).parents('tr').find('.info>h4').html();
        artist = $(this).parents('tr').find('.info>span').eq(0).children('p').html();

        if (num <= 0) {
            if (!shop_del(title, artist)) {
                $(this).val(1);
            }
        } else {
            $.each(shop_arr, function(i, o) {
                if ((o.albumName == title) && (o.artist == artist)) {
                    shop_arr[i]['len'] = num;
                    get_shop();
                }
            });
        }
    });

    // 결제하기
    $('.modal-footer>.btn-primary').on('click', function() {
        if (shop_arr.length > 0) {
            alert('결제가 완료되었습니다.');
            shopcart_btn(1);
            shop_arr = [];
            get_shop();
            $('#myModal').modal('hide');
        }
    });

    // shopping cart 수량 변경됐을때
    function shopcart_btn (a = 0) {
        $.each(shop_arr, function(i, o) {
            if (o.len <= 0 || a == 1) {
                let album = $('.contents .produ-cost>h5:contains("' + o.albumName + '")').parent('.produ-cost');

                $(album).find('.shopbtn>.btn').html('<i class="fa fa-shopping-cart"></i> 쇼핑카트담기');
            } else {
                let album = $('.contents .produ-cost>h5:contains("' + o.albumName + '")').parent('.produ-cost');

                $(album).find('.shopbtn>.btn').html('<i class="fa fa-shopping-cart"></i> 추가하기 (' + shop_arr[i]['len'] + '개)');
            }
            
        });
    }

    // modal 닫혔을 때
    $('#myModal').on('hidden.bs.modal', function() {
        shopcart_btn();
    });



    // init
    $('.contents').empty();
    all();
    get_shop();

    //onbeforeunload 사용자 페이지 떠나려 할 때  (새로고침, 닫기, 다른 페이지로 이동 등)
    $(window).on('beforeunload', function() {
        setCookie('shop_arr', JSON.stringify(shop_arr), 1);
    });
});