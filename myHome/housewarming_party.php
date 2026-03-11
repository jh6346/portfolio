<!-- 온라인 집들이 -->
<?php include 'lib.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_housewarming_party.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <style>
        .board_modal .know-how {
            white-space: pre-wrap;
        }
    </style>
    <script>
        var user_id = '<?php echo isset($_SESSION['user_id'])? $_SESSION['user_id'] : '' ; ?>';

        function close_modal() {
            $('.modal').hide();

            $.each($('form'), function() { //모든 form 초기화
                this.reset();
            });

            $('.modal .preview').attr('src', '');
        }

        $(function() {
            var board = $('.board').clone();
            var star = 1; //별점


            $('.write').on('click', function() {
                if (user_id) {
                    $('.write_modal').show();
                } else {
                    alert('로그인 후 이용 가능');
                }
            });
            $('.write_modal_header>.close>i').on('click', function() {
                close_modal();
            });

            
            //게시글 쓰기
            $('.write_hp_form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                
                if (user_id) {
                    $.ajax({
                        url: 'hp_board_write.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = $.trim(data);
                            if (data == 'o') {
                                alert('게시글 작성 완료');
                                close_modal();
                            } else {
                                alert(data);
                            }
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                } else {
                    alert('로그인 후 이용 가능');
                }
            });
            function preview(preview, e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(preview).attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }

            $('#file_before').on('change', function(e) {
                // var file = e.target.files[0];
                preview($(this).parent().find('.preview'), e);
            });
            $('#file_after').on('change', function(e) {
                preview($(this).parent().find('.preview'), e);
            });
          


            //게시글 클릭
            $(document).on('click', '.board', function() {
                let data_id = $(this).attr('data-id');

                //게시글 불러오기
                $.ajax({
                    url: 'hp_board_select.php',
                    method: 'POST',
                    dataType: 'JSON',
                    data: { id : data_id },
                    success: function(data) {
                        // board id
                        $('.board_modal').attr('data-id', data['board_id']);

                        //전
                        $('.board_modal .imgs>.before_img').attr('src', 'img/housewarming_party/' + data['before_img']);

                        //후
                        $('.board_modal .imgs>.after_img').attr('src', 'img/housewarming_party/' + data['after_img']);

                        $('.board_modal .subject').text(data['subject']);
                        //작성자
                        $('.board_modal .user .name').text('' + data['user_name']);
                        $('.board_modal .user .id').text('(@' + data['user_id'] + ")");

                        //작성일
                        $('.board_modal .ts').text(data['regdate']);

                        //평점
                        if (data['star'] == '') {
                            
                            $('.board_modal .rating').html('<i class="fa fa-star"> 0');
                        } else {
                            $('.board_modal .rating').html('<i class="fa fa-star"> ' + data['star']);
                        }

                        //노하우
                        $('.board_modal .know-how').text(data['content']);

                        //이미 평점을 준 게시글
                        console.log(data['star_c']);
                        if (data['star_c'] != '') {
                            $('.stars').find('.star').eq(data['star_c']).prevAll().html('<i class="fa fa-star">');
                            $('.stars>.star').eq(data['star_c'] - 1).nextAll('.star').html('<i class="fa fa-star-o">');

                            $('.rating_btn').attr('disabled', true);
                        } else if(data['user_id'] == user_id) {
                            $('.rating_btn').attr('disabled', true);
                        } else {
                            $('.rating_btn').prop('disabled', false);
                        }
                    }, error: function(e) {
                        alert(e);
                    }
                });

                $('.board_modal').show();
            });

            //닫기
            $('.board_modal_header .close>i').on('click', function() {
                $('.board_modal').hide();
            });

            //평점 주기
            $('.board_modal .stars>.star').on('click', function() {
                if (!($('.rating_btn').attr('disabled'))) {
                    $(this).next().prevAll().html('<i class="fa fa-star">');
                    $(this).nextAll('.star').html('<i class="fa fa-star-o">');
                    star = $(this).index() + 1;
                }
            });
            $('.board_modal .rating_btn').on('click', function() {
                if (user_id) {
                    $.ajax({
                        url: 'star_rating.php',
                        method: 'POST',
                        data: { board_id : $('.board_modal').attr('data-id') , star : star },
                        success: function(data) {
                            data = $.trim(data);
                            if (data =='o') {
                                $('.rating_btn').attr('disabled', true);
                            } else if (data == 'x') {
                                alert('이미 평점 작성함');
                            } else {
                                alert(data);
                            }
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                } else {
                    alert('로그인 후 이용 가능');
                }
            });

            //모달 닫기
            $(window).click(function(e) {
                var t = $(e.target);
                if (t.hasClass('modal'))
                    $('.modal').hide();
            });
            
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="hp_content">
        <div class="board_list">
            <div class="wrapper">
                <?php
                    $sql = "select * from housewarming_party";
                    $rs = mysqli_query($conn, $sql);

                    $num = mysqli_num_rows($rs); //전체 데이터 개수
                    $list_num = 12; // 한 페이지 데이터 개수
                    $page_num = 3; // 한 블럭 페이지 개수
                    $page = isset($_GET['page']) ? $_GET['page'] : 1; //현재 페이지
                    $total_page = ceil($num / $list_num); //전체 페이지 개수
                    $total_block = ceil($total_page / $page_num); //전체 블럭 개수
                    $now_block = ceil($page / $page_num); //현재 블럭
                    $s_pageNum = ($now_block - 1) * $page_num + 1; //블럭 시작 페이지 번호
                    if ($s_pageNum <= 0)
                        $s_pageNum = 1;

                    $e_pageNum = $now_block * $page_num; //블럭 마지막 페이지 번호
                    if ($e_pageNum > $total_page)
                        $e_pageNum = $total_page;
                ?>

                <?php
                    $start = ($page - 1) * $list_num; //페이지 시작 번호
                    $sql = "select H.*, U.idx, U.id, U.name from housewarming_party H LEFT JOIN user U ON H.user_idx=U.idx order by regdate desc limit $start, $list_num";
                    $rs = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_array($rs)) {
                        $board_id = $row['board_id'];
                ?>
                    <div class="board" data-id="<?php echo $row['board_id']; ?>" data-user-idx="<?php echo $row['user_idx']; ?>" data-regdate="<?php echo $row['regdate']; ?>">

                        <div class="board_img">
                            <div class="next"><i class="fa fa-angle-right"></i></div>
                            <img src="img/housewarming_party/<?php echo $row['before_img']; ?>" alt="beforeImg">
                            <img src="img/housewarming_party/<?php echo $row['after_img']; ?>" alt="afterImg">
                        </div>

                        <div class="board_metadata">
                            <div class="user_img">
                                <img src="img/user/pingu.jpg" alt="user_img">
                            </div>
                            
                            <div class="metadata_right">
                                <div class="wrapper">
                                    <div class="name">
                                        <?php echo $row['name']; ?>
                                        <!-- <span class="id">(@<?php echo $row['id']; ?>)</span> -->
                                    </div>
                                    <div>&nbsp·&nbsp</div>
                                    <div class="regdate">
                                        <?php echo date('Y-m-d', strtotime($row['regdate'])); ?>
                                    </div>
                                </div>

                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <?php
                                        $sql = "select floor(avg(cnt)) as star from star where board_id='$board_id'";
                                        $rs_star = mysqli_query($conn, $sql);
                                        $row_star = mysqli_fetch_array($rs_star);
                                        echo ($row_star['star']) ? $row_star['star'] : '0';
                                    ?>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>

            <div class="btns">
                <button class="write btn1"><i class="fa fa-pencil"></i>글쓰기</button>
            </div>

            <div class="page">
                <?php //이전 페이지
                    if ($page <= 1) {
                ?>
                    <a href="housewarming_party.php?page=1" class="prev"><i class="fa fa-angle-left"></i></a>
                <?php
                    } else {
                ?>
                    <a href="housewarming_party.php?page=<?php echo ($page - 1); ?>" class="prev"><i class="fa fa-angle-left"></i></a>
                <?php
                    }
                ?>

                <?php //페이지 번호
                    for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {
                        if ($page == $print_page) {
                ?>
                            <span class="current_page_num"><?php echo $print_page; ?></span>
                <?php
                        } else { ?>
                            <a href="housewarming_party.php?page=<?php echo $print_page; ?>" <?php if ($page != $print_page) echo 'class="page_num"';?>><?php echo $print_page;?></a>
                <?php
                        }
                    }
                ?>

                <?php //다음 페이지
                    if ($page >= $total_page) {
                ?>
                        <a href="housewarming_party.php?page=<?php echo $total_page; ?>" class="next"><i class="fa fa-angle-right"></i></a>
                <?php
                    } else {
                ?>
                        <a href="housewarming_party.php?page=<?php echo ($page + 1); ?>" class="next"><i class="fa fa-angle-right"></i></a>
                <?php
                    }
                ?>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>

    <!-- 게시글 쓰기 -->
    <div class="write_modal modal">
        <div class="write_modal_wrapper modal_wrapper">
            <div class="write_modal_header">
                <div class="close"><i class="fa fa-remove"></i></div>
            </div>

            <div class="write_modal_body">
                    <form class="write_hp_form" action="#" enctype="multipart/form-data" method="post">
                        <div class="subject">
                            <p class="text">제목</p>
                            <input type="text" name="subject" placeholder="제목을 입력해주세요." required>
                        </div>

                        <div class="upload_file">
                            <div class="before">
                                <span>Before</span>

                                <div class="input_img">
                                    <input type="file" name="before" id="file_before" accept="image/*" required>
                                    <img class="preview" src="">
                                </div>
                            </div>

                            <div class="after">
                                <span>After</span>

                                <div class="input_img">
                                    <input type="file" name="after" id="file_after" accept="image/*" required>
                                    <img class="preview" src="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="know-how">
                            <p class="text">노하우</p>
                            <textarea name="know-how" id="know-how" placeholder="노하우를 입력해주세요." required></textarea>
                        </div>
                        <!-- <input type="text" name="know-how" required>s -->

                        <div class="btns">
                            <input type="submit" class="btn1" id="hp_form_submit" value="작성 완료">
                        </div>
                    </form>
            </div>

            <div class="write_modal_footer">

            </div>
        </div>
    </div>


    <!-- 게시글 모달 -->
    <div class="board_modal modal">
        <div class="board_modal_wrapper modal_wrapper">
            <div class="board_modal_header">
                <div class="close"><i class="fa fa-remove"></i></div>
                
                <div class="board_modal_metadata">
                    <div class="user">
                        <div class="img"><img src="img/user/pingu.jpg" alt="user_img"></div>
                        <span class="name">이름</span>
                        <span class="id">(@아이디)</span>
                    </div>

                    <div class="subject">
                        subject
                    </div>

                    <div class="ts">
                        2020-01-31
                    </div>

                    <div class="rating">
                        5
                    </div>
                </div>

            </div>

            <div class="board_modal_body">

                <div class="imgs">
                    <img src="img/housewarming_party/1_before.jpg" class="before_img" alt="before">
                    <img src="img/housewarming_party/1_after.jpg" class="after_img" alt="after">
                </div>                

                <div class="know-how">
                    노하우
                </div>

                <div class="rating_wrapper">
                    <div class="stars">
                        <span class="star"><i class="fa fa-star"></i></span>
                        <span class="star"><i class="fa fa-star-o"></i></span>
                        <span class="star"><i class="fa fa-star-o"></i></span>
                        <span class="star"><i class="fa fa-star-o"></i></span>
                        <span class="star"><i class="fa fa-star-o"></i></span>
                        <span></span>
                    </div>
                    <button class="rating_btn">
                        평점 주기
                    </button>
                </div>
            </div>

            <div class="board_modal_footer">

            </div>
        </div>
    </div>
</body>
</html>