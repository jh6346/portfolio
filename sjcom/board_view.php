<?php
    include 'lib.php';
    $num = $_GET['num'];

    $sql = " update board set hit=hit+1 where num=$num;";
    mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        $(document).ready(function() {
            $('.list').on('click', function() {
                location.replace('board_list.php');
            });

            $('.write').on('click', function() {
                location.replace('board_write_form.php');
            });

            //삭제
            $('.delete').on('click', function() {
                $('.delete_modal').show();
            });
            $('.yes').on('click', function() {
                $.ajax({
                    url: 'board_delete.php',
                    method: 'POST',
                    data: {num: <?php echo $num; ?>},
                    success: function(data) {
                        data = $.trim(data);
                        if (data == 'O') {
                            alert('게시물이 삭제되었습니다.');
                            location.replace('board_list.php');
                        } else {
                            alert(data);
                        }
                    }, error: function(e) {
                        alert(e);
                    }
                });
            });
            $('.no').on('click', function() {
                $('.delete_modal').hide();
            });

            //수정
            $('.edit').on('click', function() {
                location.replace('board_write_form.php?num=<?php echo $num;?>');
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="delete_modal">
        <div class="delete_content">
            <p>게시물을 삭제합니다.</p>

            <div class="button">
                <button class="yes">YES</button>
                <button class="no">NO</button>
            </div>
        </div>
    </div>

    <div class="board_view">
        <h2>게시판</h2>
        <hr>

        <?php
            $sql = "select * from sjcom_board where num=$num";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
        ?>

        <div class="title">
            <p class="subject"><?php echo $row['subject']; ?></p>
            <p class="name"><?php echo $row['name']; ?> |&nbsp</p>
            <p class="hit">조회: <?php echo $row['hit']; ?> |</p>
        </div>

        <div class="content">
            <div class="content_img">
                <img src="./uploads/board/<?php echo $row['uniqfilename_0'] ?>"; alt="">
                <img src="./uploads/board/<?php echo $row['uniqfilename_1'] ?>"; alt="">
                <img src="./uploads/board/<?php echo $row['uniqfilename_2'] ?>"; alt="">
            </div>
            
            <div class="text"><?php echo trim($row['content']); ?></div>
        </div>
        <hr>
        <div class="button">
            <button class="list">목록</button>
            <?php
                if (isset($_SESSION['user_info'])) {
                    if ($_SESSION['user_info']['id'] == $row['id']) {
            ?>
                <button class="edit">수정</button>
                <button class="delete">삭제</button>
            <?php
                    }
                }
            ?>
            <button class="write">글쓰기</button>
        </div>
    </div>
</body>
</html>