
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
        }
        .header_top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
        }
        .logo:hover {
            cursor: pointer;
        }
        .lnb {
            width: 100%;
            display: flex;
            padding: 10px 20px;
            background-color: gray;
        }
        .lnb>a {
            color: white;
            margin: 0 5px;
        }
    </style>
    <script>
        var user_id = "<?php echo isset($_SESSION['user_info']['id'])?$_SESSION['user_info']['id']:''; ?>";

        $(document).ready(function() {
            $('.logo').on('click', function() {
                location.replace('index.php');
            });
            $('.signup').on('click', function() {
                location.replace('join_form.php');
            });
            $('.login').on('click', function() {
                location.replace('login_form.php')
            });
            $('.logout').on('click', function() {
                alert('로그아웃 되었습니다.');
                location.replace('logout.php');
            });

            if (user_id) {
                $('.login').hide();
                $('.signup').hide();
            } else {
                $('.logout').hide();
            }
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="header_top">
            <div class="logo"><img src="img/sjcom_logo.png" alt=""></div>

            <div class="login_wrapper">
                <button class="login">로그인</button>
                <button class="signup">회원가입</button>
                <button class="logout">로그아웃</button>
            </div>
        </div>

        <div class="lnb">
            <a href="index.php">home</a>
            <a href="guest.php">방명록</a>
            <a href="board_list.php">게시판</a>
            <a href="board_data_list.php">자료실</a>
            <a href="gallery.php">갤러리</a>
        </div>
    </div>
</body>
</html>