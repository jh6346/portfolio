<!-- 스토어 -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_store.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        function setCookie(name, value, exp) { //쿠키 저장
            // encodeURIComponent : url 인코딩
            
            var date = new Date();
            date.setTime(date.getTime() + exp*24*60*60*1000);
            document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + date.toUTCString() + ';path=/';
        }

        function getCookie(name) { //쿠키 가져오기
            // decodeURIComponent : url 디코딩

            var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
            return value ? decodeURIComponent(value[2]) : null;
        }

        function str_to_int(str) { //문자열 숫자만
            return parseInt(str.replace(/[^-0-9]/g, ''));
        }

        //장바구니
        function cart_row(id, img, brand, name, price, num) {
            //price 숫자만
            let replace_price = str_to_int(price);

            return $('<tr />', {
                class : 'cart_product',
                'data-id' : id,
                'data-img' : img,
                'data-brand' : brand,
                'data-name' : name,
                'data-price' : price
            }).append(
                $('<td><img src="img/store/' + img + '" alt="product-img"></td>'),
                $('<td />', { class : 'cart_text' }).append(
                    $('<div />', { class : 'product_name' }).append(name),
                    $('<div />', { class : 'brand' }).append(brand),
                    $('<div />', { class : 'price' }).append(price)
                ),
                $('<td><input class="num" type="number" value="' + num + '"></td>'),
                $('<td />', { class : 'amount' }).append((replace_price * num).toLocaleString()),
                $('<td />').append($('<button />', {
                    class: 'remove'
                }).append('<i class="fa fa-trash"></i>'))
            );
        }

        function total() { //장바구니 총액
            let arr = $('.cart_list').find('.cart_product');
            
            let total = 0;
            $.each(arr, function(i, o) {
                let price = $(o).find('.amount').text();
                //price 정수
                price = str_to_int(price);
                
                total += price;
            });

            $('.total>span').text(total.toLocaleString());

            return total;
        }

        function del(current, arr) { //장바구니 삭제
            $.each(arr, function(i, o) {
                
                if (o['data-id'] == current.attr('data-id')) {
                    arr.splice(i, 1);
                    return false;
                }
            });

            current.remove();
            total();
        }

        




        

        $(function() {
            // setCookie('cart_arr', '', -1); //쿠키 삭제

            //클론
            var product = $('.product_list>.product').clone();
            var current_product;

            //장바구니
            var cart_arr = [];            

            function get_product_all() { //상품 목록 전체 가져오기
                $.ajax({
                    url: 'store.json',
                    dataType: 'JSON',
                    success: function(data) {
                        $('.product_list').empty();
                        
                        $.each(data, function(i, o) {
                            let clone = product.clone();

                            clone.find('img').attr('src', 'img/store/' + o.photo);
                            clone.find('.product_name').html(o.product_name);
                            clone.find('.brand').html(o.brand);
                            clone.find('.price').html('₩ ' + o.price);

                            clone.attr('data-id', o.id);
                            clone.attr('data-img', o.photo);
                            clone.attr('data-brand', o.brand);
                            clone.attr('data-name', o.product_name);
                            clone.attr('data-price', o.price);

                            $('.product_list').append(clone);
                        });
                    }, error: function(e) {
                        alert(e);
                    }
                });
            }
            //상품 목록 전체 가져오기
            get_product_all();

            //장바구니 쿠키 가져오기
            if (getCookie('cart_arr') != null) {
                cart_arr = JSON.parse(getCookie('cart_arr')); //cart_arr라는 이름으로 저장된 쿠키 가져오기

                $.each(cart_arr, function(i, o) {
                    let id = o['data-id'];
                    let img = o['data-img'];
                    let brand = o['data-brand'];
                    let name = o['data-name'];
                    let price = o['data-price'];
                    let num = o['data-num'];
                    
                    // console.log($('.product_list>.product[data-id="1"]').length);
                    // console.log($('.product_list>.product').html());

                    let row = cart_row(id, img, brand, name, price, num);
                    $('.cart_list>table>tbody').append(row);
                    $('.cart>.empty').hide();
                });

                total();
            }

            

            //상품에 draggable
            $(document).on('mouseenter', '.product', function() {
                $('.product').draggable({ revert: 'invalid', helper: 'clone' });

                current_product = $(this).clone();
            });

            //장바구니
            $('.cart').droppable({
                hoverClass: '',
                drop : function() {
                    if ($('.cart_list>table>tbody>.cart_product[data-id="' + current_product.attr('data-id') + '"]').length > 0) {
                        alert("이미 장바구니에 담긴 상품입니다.");
                    } else {
                        let id = current_product.attr('data-id');
                        let img = current_product.attr('data-img');
                        let brand = current_product.attr('data-brand');
                        let name = current_product.attr('data-name');
                        let price = current_product.attr('data-price');
                        let num = 1;

                        let row = cart_row(id, img, brand, name, price, num);
                        $('.cart_list>table>tbody').append(row);

                        cart_arr.push({
                            'data-id' : current_product.attr('data-id'),
                            'data-img' : current_product.attr('data-img'),
                            'data-brand' : current_product.attr('data-brand'),
                            'data-name' : current_product.attr('data-name'),
                            'data-price' : current_product.attr('data-price'),
                            'data-num' : 1
                        });
                        total();
                    }
                    
                    //cart에 하나라도 있으면 '이곳에 상품을 넣어주세요' 제거
                    if (($('.cart_list').children().length) > 0) {
                        $('.cart>.empty').hide();
                    }
                }
            });
            
            //장바구니 삭제
            $(document).on('click', '.cart_product .remove', function() {
                if (confirm('장바구니에서 삭제하시겠습니까?')) {
                    let current = $(this).parents('.cart_product');

                    del(current, cart_arr);
                }
            });

            //장바구니 수량 변경
            $(document).on('change', '.cart_product>td>.num', function() {
                let num = $(this).val();
                let current = $(this).parents('.cart_product');
                let id = current.attr('data-id');

                if (num < 1) {
                    if (confirm("장바구니에서 삭제하시겠습니까?")) {
                        del(current, cart_arr);
                    } else {
                        $(this).val(1);
                    }
                } else {
                    $.each(cart_arr, function(i, o) {
                        if (o['data-id'] == id) {
                            o['data-num'] = num;
                            current.find('.amount').text((str_to_int(o['data-price']) * num).toLocaleString());
                            total();
                        }
                    });
                }
            });
            

            //구매하기
            $('.cart_modal_btn').on('click', function() {
                if ($('.cart_list tbody').children().length < 1) {
                    alert('장바구니가 비어있습니다.');
                } else {
                    $('.cart_modal .total').text('총 ' + total().toLocaleString() + '원');
                    $('.cart_modal').show();
                }
            });
            $('.cart_modal_content>.close').on('click', function() {
                $('.cart_modal').hide();
            });

            //구매완료
            $('.cart_modal form').on('submit', function(e) {
                let row = "";
                e.preventDefault();

                $.each(cart_arr, function(i, o) {                    
                    row += "상품명: " + o['data-name'] + " / ";
                    row += "가격: " + o['data-price'] + " / ";
                    row += "수량: " + o['data-num'] + " / ";
                    row += "합계: " + (str_to_int(o['data-price']) * o['data-num']).toLocaleString() + "\n";
                });

                let date = new Date();
                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                let day = date.getDate();
                let hours = date.getHours();
                let minutes = date.getMinutes();
                let seconds = date.getSeconds();

                row += "총합계: " + total().toLocaleString() + "원\n";
                row += "구매일시: " + year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;

                alert(row);

                cart_arr = [];
                $('.cart_list tbody').empty();
                $('.cart_modal').hide();
                $('.cart_modal input').val("");
                total();
            });

            // - 검색 필드에 검색어를 입력하여 상품명 또는 브랜드명에 키워드가 포함되는 리스트만 볼 수 있다. 검색 결과는 검색어 입력 후 즉시 리스트에 반영되어 보여야 하며, 키워드가 하이라이트 처리된다.
            // - 검색어와 일치하는 상품이 없을 경우 ‘일치하는 상품이 없습니다.’라는 문구가 나타난다.
            //검색
            $('.masthead>.search input').on({
                keyup: function() {
                    let products = $('.product_list').find('.product');
                    let keyword = $(this).val();
                    let n = 0;
                    $(products).hide();


                    $.each(products, function(i, o) {
                        let regex = new RegExp(keyword, 'gi');

                        if ($(o).attr('data-name').includes(keyword)) { //상품 이름
                            
                            //하이라이트
                            $(o).find('.product_name:contains(' + keyword + ')').each(function() {
                                $(this).html($(this).text().replace(regex, '<span>' + keyword + '</span>'));
                            })
                            $(o).find('.product_name>span').css({
                                'display' : 'inline',
                                'background-color' : 'rgb(153, 144, 132)',
                                'color' : 'white'
                            });

                            $(o).show();
                            n++;
                        }

                        if ($(o).attr('data-brand').includes(keyword)) { //상품 브랜드

                            //하이라이트
                            $(o).find('.brand:contains(' + keyword + ')').each(function() {
                                $(this).html($(this).text().replace(regex, '<span>' + keyword + '</span>'));
                            })
                            $(o).find('.brand>span').css({
                                'display' : 'inline',
                                'background-color' : 'rgb(153, 144, 132)',
                                'color' : 'white'
                            });

                            $(o).show();
                            n++;
                        }
                    });

                    if (n <= 0) {
                        $('.search>.empty').html('"' + keyword + '" 검색 결과 일치하는 상품이 없습니다.');
                        $('.search>.empty').show();
                    } else {
                        $('.search>.empty').text('"' + keyword + '" 검색 결과');
                        keyword ? $('.search>.empty').show() : $('.search>.empty').hide();
                    }
                }
            });
            
            //사용자 페이지 떠날 때 (새로고침, 닫기, 다른 페이지...)
            $(window).on('beforeunload', function() {
                setCookie('cart_arr', JSON.stringify(cart_arr), 1); //배열(cart_arr)을 JSON 문자열로 변경하여 cart_arr라는 이름으로 쿠키 저장
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

    <div class="masthead">
        <!-- <img src="img/living-room-690174_1920.jpg" alt=""> -->
        <!-- <img src="img/furniture-635613_1920.jpg" alt=""> -->
        <div class="search">
            <div class="wrapper">
                <input class="search_input" type="text">
                <i class="fa fa-search"></i>
            </div>
            <p class="empty">
                일치하는 상품이 없습니다.
            </p>
        </div>
    </div>

    <div class="store_content">
        
        <div class="product_list">
            <div class="product">
                <img src="img/store/product_1.jpg" alt="1">
                <div class="product_name">마틸라</div>
                <div class="brand">마틸라</div>
                <div class="price">₩ 17,100</div>
            </div>
        </div>

        <div class="cart cart_empty">
            <p class="empty">
                이곳에 상품을 넣어주세요.
            </p>
            <div class="cart_list">
                <table>
                    <tbody>
                    </tbody>
                </table>

            </div>

            <div class="total">
                총합계 : <span>0</span>원
                <button class="cart_modal_btn">
                    구매하기
                </button>
            </div>
        </div>

        <div class="cart_modal">
            <div class="cart_modal_content">
                <div class="close"><i class="fa fa-remove"></i></div>
                <form action="#" method="post">
                    <table>
                        <tr>
                            <td>이름: </td>
                            <td><input type="text" name="name" required></td>
                        </tr>
                        <tr>
                            <td>주소: </td>
                            <td><input type="text" name="address" required></td>
                        </tr>
                        <tr>
                            <td class="total">총 0원</td>
                            <td style="text-align:right;"><button class="buy">구매 완료</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>