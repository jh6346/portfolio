<!-- 회원가입 -->
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
            $('.join_form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'join_insert.php',
                    method: 'POST',
                    data: $('.join_form').serialize(),
                    success: function(data) {
                        if (data == 'o') {
                            alert('성공');
                            location.replace('index.php');
                        } else
                            alert(data);
                        
                    }, error: function(e) {
                        alert(e);
                    }
                });
            });

            //이미지 미리보기
            $('#file').on('change', function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result)
                }
                reader.readAsDataURL(file);
            });
        });

    </script>
</head>
<body>
    <div class="join_page">
        <form action="" class="join_form">
            <table>
                <tr>
                    <th colspan="2"><!-- 심벌로고 -->
                        <a href="index.php" class="logo">
                            <i class="fa fa-home"></i>
                            <span>내집꾸미기</span>
                        </a>
                    </th>
                </tr>
                <tr>
                    <td>아이디</td>
                    <td><input type="text" name="id" required></td>
                </tr>
                <tr>
                    <td>비밀번호</td>
                    <td><input type="password" name="pw" autoComplete="off" required></td>
                </tr>
                <tr>
                    <td>이름</td>
                    <td><input type="text" name="name" required></td>
                </tr>
                <tr>
                    <td>사진</td>
                    <td><input type="file" name="img" id="file" accept="image/*"><img id="preview" alt=""></td>
                </tr>
                <tr>
                    <td><input type="submit" class="signup_btn" value="가입 완료"></td>
                    <td></td>
                </tr>
            </table>
        </form>

        <?php include "footer.php"; ?>
    </div>
</body>
</html>