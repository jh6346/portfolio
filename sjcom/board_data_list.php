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
    <script>
        $(document).ready(function() {
            $('.write').on('click', function() {
                if (user_id) {
                    location.replace('board_data_write.php');
                } else {
                    alert('로그인 후 사용하세요.');
                }
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="section_board">
        <h2>자료실</h2>
        <hr>
        <p>&diams; 총 <?php
            $sql="select * from sjcom_download";
            $result = mysqli_query($conn, $sql);
            echo mysqli_num_rows($result);
        ?>개의 게시물이 있습니다.</p>
        <div class="board_list">
            <table>
                <thead>
                    <tr>
                        <th width="10%">번호</th>
                        <th width="60%">제목</th>
                        <th width="10%">글쓴이</th>
                        <th width="10%">등록일</th>
                        <th width="10%">조회</th>
                    </tr>
                </thead>

                <?php
                    $sql = "select * from sjcom_download";
                    $result = mysqli_query($conn, $sql);

                    $num = mysqli_num_rows($result); //전체 데이터 개수
                    $list_num = 5; //한 페이지 데이터 개수
                    $page_num = 3; //한 블럭 페이지 개수
                    $page = isset($_GET['page'])? $_GET['page'] : 1; //현재 페이지
                    $total_page = ceil($num / $list_num); //전체 페이지 개수
                    $total_block = ceil($total_page / $page_num); //전체 블럭 개수
                    $now_block = ceil($page / $page_num); //현재 블럭

                    $s_pageNum = ($now_block - 1) * $page_num + 1; //블럭 시작 페이지 번호
                    if ($s_pageNum <= 0) {
                        $s_pageNum = 1;
                    }

                    $e_pageNum = $now_block * $page_num; //블럭 마지막 페이지 번호
                    if ($e_pageNum > $total_page) {
                        $e_pageNum = $total_page;
                    }
                ?>


                <tbody>
                    <?php
                        $start = ($page - 1) * $list_num; //페이지 시작 번호
                        $sql = "select * from sjcom_download order by num desc limit $start, $list_num";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['num']; ?></td>
                        <td><a class="subject" href="./board_data_view.php?num=<?php echo $row['num']; ?>"><?php echo $row['subject']; ?></a></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['regdate']; ?></td>
                        <td><?php echo $row['hit']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
                
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <?php //이전 페이지
                                if ($page <= 1) {
                            ?>
                                    <a href="board_data_list.php?page=1" class="prev">&blacktriangleleft;</a>
                            <?php
                                } else {
                            ?>
                                    <a href="board_data_list.php?page=<?php echo ($page - 1);?>" class="prev">&blacktriangleleft;</a>
                            <?php }?>

                            <?php //페이지 번호
                                for ($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++) {
                            ?>
                                    <?php if ($page == $print_page) {?>
                                        <span class="current_page">[<?php echo $print_page?>]</span>
                                    <?php } else {?>
                                        <a href="board_data_list.php?page=<?php echo $print_page;?>" <?php if ($page != $print_page) echo 'class="page"';?>>[<?php echo $print_page;?>]</a>
                                    <?php } ?>
                            <?php }?>

                            <?php //다음 페이지
                                if($page >= $total_page) {
                            ?>
                                    <a href="board_data_list.php?page=<?php echo $total_page;?>" class="next">&blacktriangleright;</a>
                            <?php } else {?>
                                    <a href="board_data_list.php?page=<?php echo ($page + 1); ?>" class="next">&blacktriangleright;</a>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
                </tfoot>
                <tr>
                    <td colspan="5" style="text-align:right;"><button class="write">글쓰기</button></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>