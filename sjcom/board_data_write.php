<!-- 자료실 -->
 <?php include 'lib.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .section_download {
            padding: 50px;
        }
        textarea {
            resize: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.board_form').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let btn = $(e.originalEvent.submitter);

                if (btn.hasClass('write')) {
                    $.ajax({
                        url: 'download_insert.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = $.trim(data);
                            if (data == 'O') {
                                alert('게시글이 작성되었습니다.');
                                location.replace('board_data_list.php');
                            } else {
                                alert(data);
                            }
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                } else if (btn.hasClass('update')) {
                    formData.append('num', <?php if(isset($_GET['num'])) echo $_GET['num']; ?>);

                    $.ajax({
                        url: 'download_update.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            data = $.trim(data);
                            if (data == 'O') {
                                alert('게시글이 수정되었습니다.');
                                location.replace('board_data_view.php?num=<?php if(isset($_GET['num'])) echo $_GET['num']; ?>');
                            } else {
                                alert(data);
                            }
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                }

                
            });

            $('.list').on('click', function(e) {
                e.preventDefault();

                location.replace('board_data_list.php');
            })
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="section_download">
        <h2>자료실</h2>
        <div class="write_board">
            <form action="" class="board_form" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th colspan="2">글쓰기</th>
                    </tr>
                    <tr>
                        <td>별명</td>
                        <td><?php echo $_SESSION['user_info']['name']; ?></td>
                    </tr>

                    <?php if(isset($_GET['num'])) {
                        $num = $_GET['num'];
                        $sql = "select * from sjcom_download where num=$num";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                    } else $num = 0;
                    ?>
                    <tr>
                        <td>제목</td>
                        <td><input type="text" name="subject" style="width:100%;" value="<?php if($num) echo $row['subject']?>"required></td>
                    </tr>
                    <tr>
                        <td>내용</td>
                        <td><textarea name="content" rows="30"><?php if($num) echo $row['content'];?></textarea required></td>
                    </tr>
                    <tr>
                        <td>이미지파일1</td>
                        <td>
                            <?php if($num && $row['filename_0']) {?>
                                <input type="file" name="file1" disabled>
                                <p class="deletefile"><?php echo $row['filename_0'];?> 파일이 등록되어 있습니다. <input type="checkbox" name="delete[]" value="filename_0">삭제</p>
                            <?php } else {?>
                                <input type="file" name="file1">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>이미지파일2</td>
                        <td>
                            <?php if($num && $row['filename_1']) {?>
                                <input type="file" name="file2" disabled>
                                <p class="deletefile"><?php echo $row['filename_1'];?> 파일이 등록되어 있습니다. <input type="checkbox" name="delete[]" value="filename_1">삭제</p>
                            <?php } else {?>
                                <input type="file" name="file2">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>이미지파일3</td>
                        <td>
                            <?php if($num && $row['filename_2']) {?>
                                <input type="file" name="file3" disabled>
                                <p class="deletefile"><?php echo $row['filename_2'];?> 파일이 등록되어 있습니다. <input type="checkbox" name="delete[]" value="filename_2">삭제</p>
                            <?php } else {?>
                                <input type="file" name="file3">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;">
                            <?php
                                if ($num) {
                            ?>
                                <input type="submit" class="update" value="확인">
                            <?php } else { ?>
                                <input type="submit" class="write" value="글쓰기">
                            <?php } ?>
                            <button class="list">목록</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    
</body>
</html>