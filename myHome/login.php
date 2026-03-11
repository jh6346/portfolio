<!-- 로그인 -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/fontawesome/css/font-awesome.css">
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <style>
        body {
            height: 100vh;
        }

    </style>
    <script>
        $(function() {
            $('.login_form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'login_check.php',
                    method: 'POST',
                    data: $('.login_form').serialize(),
                    success: function(data) {
                        data = $.trim(data);
                        if (data == 'o') {
                            location.replace('index.php');
                        } else {
                            alert(data);
                        }
                    }, error: function(e) {
                        alert(e);
                    }
                });
                
            })
        });
    </script>
</head>
<body>
    <div class="login_page">
        <form action="" class="login_form">
            <table>
                <tr>
                    <th><!-- 심벌로고 -->
                        <a href="index.php" class="logo">
                            <i class="fa fa-home"></i>
                            <span>내집꾸미기</span>
                        </a>
                    </th>
                </tr>
                <tr>
                    <td><input type="text" name="id" placeholder="아이디를 입력해주세요." required></td>
                </tr>
                <tr>
                    <td><input type="password" name="pw" placeholder="비밀번호를 입력해주세요." autoComplete="off" required></td>
                </tr>
                <tr>
                    <td class="signup"><a href="join.php">회원가입</a></td>
                </tr>
                <tr>
                    <td><input type="submit" class="login_btn" value="로그인"></td>
                </tr>
            </table>
        </form>

        <?php include "footer.php"; ?>
    </div>
</body>
</html>