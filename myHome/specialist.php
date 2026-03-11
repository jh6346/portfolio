<!-- 전문가 -->
 <?php include 'lib.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_specialist.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <style>
        .review_list {
            display: none;
        }
        .info {
            display: flex;
        }
        .img>img {
            width: 100px;
        }
    </style>
    <script>
        $(document).ready(function() {
            var user_id = "<?php echo isset($_SESSION['user_id'])? $_SESSION['user_id'] : ''; ?>";
            var star = 1; //별점
            var spl_idx; var spl_img; var spl_name;

            //전문가 클릭
            $('.tab>.info').click(function() {
                $(this).parent().find('.review_list').slideToggle();
                $(this).toggleClass('tab_click');
            });

            //시공 후기 작성 버튼
            $('.review_btn').on('click', function() {
                spl_idx = $(this).parents('.tab').attr('data-idx');
                spl_img = $(this).parents('.tab').find('.img>img').attr('src');
                spl_name = $.trim($(this).parents('.tab').find('.name').text());
                $('.review_modal_header .img>img').attr('src', spl_img);
                $('.review_modal_header .name').text(spl_name);
                $('.review_modal').show();
            });

            //리뷰 닫기
            function review_close() {
                $('.review_modal').hide();

                //리뷰 닫기 초기화
                $('.review_modal .stars>.star').eq(0).nextAll('.star').html('<i class="fa fa-star-o">');
                star = 1;
                $('#content').val("");
            }

            $('.review_modal .close').on('click', function() {
                review_close();
            });

            //시공 후기 작성 완료
            $('.review_form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('star', star);
                formData.append('spl_idx', spl_idx);

                if (user_id) {
                    $.ajax({
                        url: 'specialist_review_insert.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = $.trim(data);

                            if (data != 'o')
                                alert(data);

                            review_close();

                        }, error: function(e) {
                            alert(e);
                        }
                    });
                } else {
                    alert('로그인 후 이용 가능');
                }
                
            });

            //평점 주기
            $('.review_modal .stars>.star').on('click', function() {
                if (!($('.rating_btn').attr('disabled'))) {
                    $(this).next().prevAll().html('<i class="fa fa-star">');
                    $(this).nextAll('.star').html('<i class="fa fa-star-o">');
                    star = $(this).index() + 1;
                }
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="specialist_content">

        <div class="specialist_list">            

            <?php
                $sql = "select * from user where a=1";
                $rs = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($rs)) {
                    $spl_idx = $row['idx'];
            ?>
                <div class="tab" data-idx="<?php echo $spl_idx; ?>">
                    <div class="info">
                        <div class="img">
                            <img src="img/specialist/<?php echo $row['img']; ?>" alt="">
                        </div>

                        <div class="info_right">
                            <div class="wrapper">
                                <div class="name">
                                    <?php echo $row['name']; ?>
                                </div>

                                <div class="id">
                                    · <?php echo $row['id']; ?>
                                </div>
                            </div>

                            <div class="rating">
                                <?php
                                    $sql = "select floor(avg(star)) as star from specialist_review where spl_idx='$spl_idx'";
                                    $rs_star = mysqli_query($conn, $sql);
                                    $row_star = mysqli_fetch_array($rs_star);

                                    $star = ($row_star['star'] != null) ? $row_star['star'] : 0;

                                    $i = 0;
                                    for ($i; $i < $row_star['star']; $i++)
                                        echo '<i class="fa fa-star star"></i>';
                                    for ($i; $i < 5; $i++)
                                        echo '<i class="fa fa-star-o star"></i>';
                                    // echo '<div class="star">' . $star . '</div>';
                                ?>
                                
                            </div>
                        </div>
                    </div>

                    <div class="review_list">
                        <table>
                            <thead>
                                <!-- <tr>
                                    <th>사진</th>
                                    <th>작성자</th>
                                    <th>비용</th>
                                    <th>내용</th>
                                    <th>평점</th>
                                </tr> -->
                            </thead>
                            
                            <tbody>
                                <?php
                                    // $sql = "select * from specialist_review where spl_idx='$spl_idx'";
                                    // $sql = "SELECT  S.*, U.id spl_id, U.name spl_name, (SELECT U.id FROM user U WHERE S.user_idx=U.idx) user_id, (SELECT U.name FROM user U WHERE S.user_idx=U.idx) user_name FROM specialist_review S LEFT JOIN user U ON S.spl_idx=U.idx WHERE spl_idx=$spl_idx";
                                    $sql = "SELECT S.*, SU.id spl_id, SU.name spl_name, UU.id user_id, UU.name user_name, UU.img user_img FROM specialist_review S LEFT JOIN user SU ON S.spl_idx = SU.idx LEFT JOIN user UU ON S.user_idx = UU.idx WHERE S.spl_idx = $spl_idx";
                                    $rs_review = mysqli_query($conn, $sql);
                                    while($row_review = mysqli_fetch_array($rs_review)) {
                                ?>
                                    <tr class="review" data-review-id="<?php echo $row_review['review_id']; ?>">
                                        <td>
                                            <img src="img/user/pingu.jpg" alt="user_img" class="user_img">
                                        </td>
                                        <td class="review_right">
                                            <div class="top">
                                                <div class="user_name"><?php echo $row_review['user_name'] ?></div>
                                                <div class="user_id">(<?php echo $row_review['user_id'] ?>)</div>
                                                <span class="dot">·</span>
                                                <div class="stars">
                                                    <?php
                                                        // echo $row_review['star'];
                                                        $i = 0;
                                                        for ($i; $i < $row_review['star']; $i++)
                                                            echo '<i class="fa fa-star star"></i>';
                                                        for ($i; $i < 5; $i++)
                                                            echo '<i class="fa fa-star-o star"></i>';
                                                    ?>
                                                </div>
                                                <span class="dot">·</span>
                                                <div class="cost">
                                                    <i class="fa fa-won"></i>
                                                    <?php echo number_format($row_review['cost']); ?>
                                                </div>
                                            </div>

                                            <div class="line"></div>

                                            <div class="content"><?php echo $row_review['content']; ?></div>
                                        </td>

                                        </td>

                                        <!-- <td><img src="img/user/pingu.jpg" class="user_img" alt="user_img"></td>
                                        <td class="user_name"><?php echo $row_review['user_name'] . "(@" . $row_review['user_id'] . ")"; ?></td>
                                        <td class="cost"><?php echo $row_review['cost']; ?></td>
                                        <td class="content"><?php echo $row_review['content']; ?></td>
                                        <td class="star"><?php echo $row_review['star']; ?></td> -->
                                    </tr>
                                <?php
                                    }
                                ?>
                                
                            </tbody>
                        </table>

                        <div class="btn_wrapper">
                            <button class="review_btn btn"><i class="fa fa-pencil"></i> 시공 후기 작성</button>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>



        <!-- 시공 후기 작성 모달 -->
        <div class="review_modal modal">
            <div class="review_modal_content modal_content">
                <div class="review_modal_header">
                    <div class="wrapper">
                        <div class="text">시공 후기 작성</div>
                        <button class="close"><i class="fa fa-close "></i></button>
                    </div>
                    <hr>
                    <div class="spl">
                        <div class="img"><img src="img/specialist/specialist1.jpg" alt="specialist"></div>
                        <div class="wrapper">
                            <div class="name">전문가 이름</div>
                            <div class="stars">
                                <span class="star"><i class="fa fa-star"></i></span>
                                <span class="star"><i class="fa fa-star-o"></i></span>
                                <span class="star"><i class="fa fa-star-o"></i></span>
                                <span class="star"><i class="fa fa-star-o"></i></span>
                                <span class="star"><i class="fa fa-star-o"></i></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="review_modal_body">
                    <form action="#" class="review_form">
                        
                        <textarea name="content" id="content" class="content" placeholder="시공 후기를 남겨주세요." required></textarea>

                        <div class="cost_input">
                            <div class="text"><i class="fa fa-won"></i></div>
                            <input type="number" id="cost" name="cost" required>
                        </div>
                        <hr>
                        <input type="submit" class="btn" id="review_submit" value="작성 완료">
                    </form>
                </div>

                <div class="review_modal_footer">
                </div>
            </div>
    </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>