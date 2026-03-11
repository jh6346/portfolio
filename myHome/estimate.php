<!-- (전문가) 보낸 견적 리스트에서 선택/미선택/진행중 수정하기 -->
<?php include 'lib.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_estimate.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        //견적 보낸 뒤 견적 보내기 버튼, 보낸 견적 리스트
        $(document).ready(function() {
            var curr_rq_id;
            // 견적 요청 버튼
            $('.rq_btn').on('click', function() {
                $('.rq_modal').show();
            });
            $('.rq_modal .close').on('click', function() {
                close_modal();
            });

            //견적 요청 작성 완료
            $('.rq_form').on('submit', function(e) {
                e.preventDefault();

                if (confirm("견적 요청을 작성하시겠습니까?")) {
                    if (user_id) {
                        $.ajax({
                            url: 'insert_estimate.php',
                            method: 'POST',
                            data: $('.rq_form').serialize(),
                            success: function(data) {
                                console.log(data);
                                close_modal();
                                location.reload();
                            }, error: function(e) {
                                alert(e);
                            }
                        });
                    } else {
                        alert('로그인 후 이용 가능');
                    }
                }
                
            });
            $('.rq_form .close').on('click', function(e) { //견적 요청 모달의 취소 버튼
                e.preventDefault();
            });
            $('.modal>.modal_content .close').on('click', function(e) {
                e.preventDefault();
                close_modal();
            })

            //받은 견적 보기 (작성 회원)
            function select_rsp_estimate() {
                $.ajax({
                    url: 'select_rsp_estimate.php',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {rq_id : curr_rq_id},
                    success: function(data) {
                        if (data == '') {
                            $('.user_estimate_list').html('<div class="user_estimate">받은 견적 없음</div>');
                        } else {
                            $('.user_estimate_list').empty();
                            $.each(data, function(i, o) {
                                let btn;

                                if (o.sel_spl_idx == null) {
                                    btn = $('<button />', {
                                        class : 'select',
                                    }).append('선택');
                                }

                                $('.user_estimate_list').append(
                                    $('<div />', { class : 'user_estimate', spl_idx : o.spl_idx }).append(
                                        $('<img />', { class : 'spl_img', src : "img/specialist/" + o.spl_img, alt : "spl_image" }),
                                        $('<div />', { class : 'spl' }).append(o.spl_name + '(@', 
                                        $('<span />', { class: 'spl_id' }).append(o.spl_id), ')'),
                                        $('<div />', { class : 'cost' }).append(parseInt(o.cost).toLocaleString()),
                                        btn
                                    )
                                );
                            });
                        }
                    }, error: function(e) {
                        alert(e);
                    }
                });
            }

            
            //견적 보기 버튼 (작성 회원)
            $('.show_btn').on('click', function() {
                curr_rq_id = $(this).parents('.estimate').attr('rq-id');

                select_rsp_estimate();

                $('.user_estimate_modal').show();
            });
            

            //견적 선택 버튼 (작성 회원)
            $(document).on('click', '.select', function() {
                let spl_id = $(this).parent().find('.spl_id').text();
                let spl_idx = $(this).parent().attr('spl_idx');

                if(confirm("'" + spl_id + "' 견적을 선택하시겠습니까?")) {
                    $.ajax({
                        url: 'update_rq_estimate.php',
                        method: 'POST',
                        data: {rq_id : curr_rq_id, spl_idx : spl_idx},
                        success: function(data) {
                            data = $.trim(data);
                            if (data == 'o') {
                                alert('견적이 선택되었습니다.');
                            } else {
                                alert(data);
                            }
                            select_rsp_estimate();
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                }
                
            });

            //견적 보내기 버튼(전문가)
            $('.send_btn').on('click', function() {
                curr_rq_id = $(this).parents('.estimate').attr('rq-id');
                $('.rsp_modal').show();
            });
            
            // 견적 보내기 입력 완료
            $('.rsp_form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('rq_id', curr_rq_id);

                if (is_admin) {
                    $.ajax({
                        url: 'insert_rsp_estimate.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = $.trim(data);

                            if (data == 'o') {
                                alert('견적을 보냈습니다.');
                                close_modal();
                            } else {
                                alert(data);
                            }
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                }
            });

            //보낸 견적 리스트(전문가)
            $('.rsp_list_btn').on('click', function() {
                $.ajax({
                    url: 'select_rsp_list.php',
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        $('.spl_estimate_list').empty();

                        $.each(data, function(i, o) {
                            let state;

                            switch(o.sel_spl_idx) {
                                case null: //아무도 선택되지 않았으면
                                    state = $('<div />', {class : 'state st0'}).append('진행중');
                                    break;
                                case user_idx: //자신이 선택되었으면
                                    state = $('<div />', {class : 'state st1'}).append('선택');
                                    break;
                                default: //그 외. 선택되었는데 자신이 아닐 경우
                                    state = $('<div />', {class : 'state st2'}).append('미선택');
                                    break;
                            }

                            $('.spl_estimate_list').append(
                                $('<div />', {
                                    class : 'spl_estimate'
                                }).append(
                                    $('<img />', {class : 'user_img', src : 'img/user/' + 'pingu.jpg', alt : 'user_img'}),
                                    // $('<div />', {class : 'user'}).append(o.user_id + '(@' + o.user_name + ')'),
                                    $('<div />', {class : 'user'}).append(
                                        $('<div />', {class : 'user_name'}).append(o.user_name),
                                        $('<div />', {class : 'user_id'}).append(o.user_id)
                                    ),
                                    $('<div />', {class : 'date'}).append(o.date),
                                    $('<div />', {class : 'content'}).append(o.content),
                                    $('<div />', {class : 'cost'}).append(parseInt(o.cost).toLocaleString()),
                                    state
                                )
                            );
                        });
                    }, error: function(e) {
                        alert(e);
                    }
                });

                $('.spl_estimate_modal').show();
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="estimate_content">
        <div class="aa"></div>

        <div class="estimate_list"> <!-- 시공 견적 요청 리스트 -->
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left;">회원</th>
                        <th>시공일</th>
                        <th>내용</th>
                        <th>상태</th>
                        <th>견적 개수</th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                    $sql = "SELECT COUNT(*) AS cnt FROM rq_estimate";
                    $rs = mysqli_fetch_array(mysqli_query($conn, $sql));
                    $num = $rs['cnt']; //전체 데이터 개수

                    $list_num = 5; // 한 페이지 데이터 개수
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
                <tbody>
                    <?php
                        //$sql = "SELECT RQ.*, U.id, U.name, U.img, U.a, (SELECT COUNT(*) FROM rsp_estimate RSP WHERE RSP.rq_id=RQ.rq_id) AS rsp_count FROM rq_estimate RQ LEFT JOIN user U ON RQ.user_idx=U.idx";
                        $rs = mysqli_query($conn, $sql);

                        
                        $start = ($page - 1) * $list_num; //페이지 시작 번호
                        $sql = "SELECT RQ.*, U.id, U.name, U.img, U.a, (SELECT COUNT(*) FROM rsp_estimate RSP WHERE RSP.rq_id=RQ.rq_id) AS rsp_count FROM rq_estimate RQ LEFT JOIN user U ON RQ.user_idx=U.idx ORDER BY RQ.rq_id DESC LIMIT $start, $list_num";
                        $rs = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_array($rs)) {
                            $rq_id = $row['rq_id'];
                    ?>
                        <tr class="estimate" rq-id="<?php echo $rq_id;?>">
                            <td class="user">
                                <div class="user_img"><img src="img/user/pingu.jpg" alt="user_img"></div>
                                <div class="wrapper">
                                    <div class="user_name">
                                        <?php echo $row['name']; ?>
                                    </div>
                                    <div class="user_id">
                                        <?php echo $row['id']; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="date"><?php echo $row['date']; ?></td>
                            <td class="content"><?php echo mb_strimwidth($row['content'], 0, 20, "…", "UTF-8"); ?></td>
                            <td class="state">
                                <?php echo ($row['sel_spl_idx'] == null) ? '<div class="st s0">진행 중</div>' : '<div class="st s1">완료</div>';?>
                            </td>
                            

                            <td class="num"><?php echo $row['rsp_count']; ?></td>

                           

                            <td class="btn">
                            <?php
                                if($user_idx == $row['user_idx']) { //로그인한 유저가 작성자일 경우
                                    echo '<button class="show_btn">견적 보기</button>';
                                } else { //로그인한 유저가 작성자가 아닐 경우
                                    $sql = "select * from rsp_estimate where rq_id=$rq_id and spl_idx='$user_idx'";
                                    $rs_rsp = mysqli_query($conn, $sql);

                                    if ($is_admin && ($row['sel_spl_idx'] == '') && (mysqli_num_rows($rs_rsp) < 1)) { //로그인한 유저가 전문가이고, 상태가 진행 중이고, 견적을 보내지 않았을 경우
                            ?>
                                        <button class="send_btn">견적 보내기</button>
                            <?php
                                    }
                                }
                            ?>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="wrapper">
                                <div class="page">
                                    <?php //이전 페이지
                                        if ($page <= 1) {
                                    ?>
                                        <a href="estimate.php?page=1" class="prev"><i class="fa fa-angle-left"></i></a>
                                    <?php
                                        } else {
                                    ?>
                                        <a href="estimate.php?page=<?php echo ($page - 1); ?>" class="prev"><i class="fa fa-angle-left"></i></a>
                                    <?php
                                        }
                                    ?>

                                    <?php //페이지 번호
                                        for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {
                                            if ($page == $print_page) {
                                    ?>
                                                <span class="current_page_num page_num"><?php echo $print_page; ?></span>
                                    <?php
                                            } else { ?>
                                                <a href="estimate.php?page=<?php echo $print_page; ?>" <?php if ($page != $print_page) echo 'class="page_num"';?>><?php echo $print_page;?></a>
                                    <?php
                                            }
                                        }
                                    ?>

                                    <?php //다음 페이지
                                        if ($page >= $total_page) {
                                    ?>
                                            <a href="estimate.php?page=<?php echo $total_page; ?>" class="next"><i class="fa fa-angle-right"></i></a>
                                    <?php
                                        } else {
                                    ?>
                                            <a href="estimate.php?page=<?php echo ($page + 1); ?>" class="next"><i class="fa fa-angle-right"></i></a>
                                    <?php
                                        }
                                    ?>
                                </div>

                                <div class="btns">
                                    <button class="rq_btn"><i class="fa fa-pencil"></i> 견적 요청</button>
                                    <?php if($is_admin) { ?>
                                        <button class="rsp_list_btn">보낸 견적</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>

                        <!-- <td colspan="2">
                            <button class="rq_btn"><i class="fa fa-pencil"></i> 견적 요청</button>
                            <?php if($is_admin) { ?>
                                <button class="rsp_list_btn">보낸 견적</button>
                            <?php } ?>
                        </td> -->
                    </tr>
                </tfoot>
            </table>

            
        </div>

        

        


        <div class="rq_modal modal"> <!-- 견적 요청 -->
            <div class="rq_modal_content modal_content">
                <div class="rq_modal_header modal_header">
                    <span>견적 요청</span>
                    <i class="close fa fa-close"></i>
                </div>
                <div class="line"></div>

                <div class="rq_modal_body">
                    <form action="#" class="rq_form">
                        <div class="date">
                            <div class="text"><i class="fa fa-calendar"></i> 시공일</div>
                            <input type="date" id="date" name="date" placeholder="날짜 선택" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>    

                        <textarea name="content" id="content" placeholder="시공 요청 사항을 입력해주세요." required></textarea>

                        <div class="btns">
                            <button class="close">취소</button>
                            <input type="submit" class="submit" value="작성 완료">
                        </div>
                    </form>
                </div>

                <div class="rq_modal_footer">
                </div>
            </div>
        </div>

        <div class="rsp_modal modal"> <!-- 견적 보내기, 전문가만 / 비용, 입력 완료 필드-->
            <div class="rsp_modal_content modal_content">
                <div class="rsp_modal_header modal_header">
                    <span>견적 보내기</span>
                    <i class="close fa fa-close"></i>
                </div>

                <div class="line"></div>

                <div class="rsp_modal_body">
                    <form action="#" class="rsp_form">
                        <div class="cost">
                            <div class="text"><i class="fa fa-credit-card"></i>비용</div>
                            <input type="number" id="rsp_cost" name="cost" placeholder="견적 비용을 입력해주세요." required>
                        </div>
                        <div class="btns">
                            <button class="close">취소</button>
                            <input type="submit" class="submit" value="입력 완료">
                        </div>
                    </form>
                </div>

                <div class="rsp_modal_footer">

                </div>
            </div>
        </div>

        <div class="spl_estimate_modal modal"> <!-- 보낸 견적 리스트(전문가만) -->
            <div class="spl_estimate_content modal_content modal_content">
                <div class="spl_estimate_header modal_header">
                    <span>보낸 견적</span>
                    <i class="close fa fa-close"></i>
                </div>

                <div class="line"></div>

                <div class="spl_estimate_list">
                    <div class="spl_estimate">
                        <img class="user_img" src="img" alt="img" >
                        <!-- <div class="user">회원이름(@아이디)</div> -->
                        <div class="user">
                            <div class="user_name">회원이름</div>
                            <div class="user_id">회원아이디</div>
                        </div>
                        <div class="date">시공일</div>
                        <div class="content">내용</div>
                        <div class="cost">비용</div>
                        <div class="state">선택/미선택/진행중</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="user_estimate_modal modal"> <!-- 받은 견적 리스트(요청 작성한 회원만) -->
            <div class="user_estimate_content modal_content">
                <div class="user_estimate_header modal_header">
                    <span>견적 보기</span>
                    <i class="close fa fa-close"></i>
                </div>

                <div class="line"></div>

                <div class="user_estimate_list">
                    <div class="user_estimate">
                        <img class="spl_img" src="img" alt="spl_image">
                        <div class="spl">전문가이름(@아이디)</div>
                        <div class="cost">비용</div>
                        <button class="select">선택</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>