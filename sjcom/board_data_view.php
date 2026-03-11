<!-- 자료실 -->
<?php
    include 'lib.php';
    $num = $_GET['num'];
    $sql = "update download set hit=hit+1 where num=$num";
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
                location.replace('board_data_list.php');
            });

            $('.write').on('click', function() {
                location.replace('board_data_write.php');
            });

            //삭제
            $('.delete').on('click', function() {
                $('.delete_modal').show();
            });
            $('.yes').on('click', function() {
                $.ajax({
                    url: 'download_delete.php',
                    method: 'POST',
                    data: {num: <?php echo $num;?>},
                    success: function(data) {
                        data = $.trim(data);
                        if (data == 'O') {
                            alert('게시물이 삭제되었습니다.');
                            location.replace('board_data_list.php');
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
                location.replace('board_data_write.php?num=<?php echo $num;?>');
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

    <div class="data_view">
        <h2>자료실</h2>
        <hr>

        <?php
            $sql = "select * from sjcom_download where num=$num";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
        ?>
        <div class="title">
            <p class="subject"><?php echo $row['subject']; ?></p>
            <p class="name"><?php echo $row['name']; ?> |&nbsp</p>
            <p class="hit">조회 : <?php echo $row['hit']; ?> | </p>
        </div>

        <div class="files">
            <p class="file1">
                <?php
                    if($row['filename_0']) {
                        echo '&diams; 첨부파일 : ';
                        echo $row['filename_0'];
                        echo ' (' . filesize('./uploads/download/' . $row['uniqfilename_0']) . ' Byte)';
                        ?>
                        <a href="./download.php?file=<?php echo $row['uniqfilename_0']?>">[저장]</a>
                <?php } ?>
            </p>
            <p class="file2">
                <?php
                    if($row['filename_1']) {
                        echo '&diams; 첨부파일 : ';
                        echo $row['filename_1'];
                        echo ' (' . filesize('./uploads/download/' . $row['uniqfilename_1']) . ' Byte)';
                        ?>
                        <a href="./download.php?file=<?php echo $row['uniqfilename_1']?>">[저장]</a>
                <?php } ?>
            </p>
            <p class="file3">
                <?php
                    if($row['filename_2']) {
                        echo '&diams; 첨부파일 : ';
                        echo $row['filename_2'];
                        echo ' (' . filesize('./uploads/download/' . $row['uniqfilename_2']) . ' Byte)';
                        ?>
                        <a href="./download.php?file=<?php echo $row['uniqfilename_2']?>">[저장]</a>
                <?php } ?>
            </p>
        </div>

        <div class="board_content">
            <div class="text"><?php echo trim($row['content']);?></div>
        </div>

        <div class="button">
            <button class="list">목록</button>
            <?php
                if(isset($_SESSION['user_info'])) {
                    if($_SESSION['user_info']['id'] == $row['id']) {
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