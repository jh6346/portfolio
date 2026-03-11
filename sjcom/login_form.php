<?php
    include 'lib.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .content_wrapper {
            margin: 50px
        }
        #button_td {
            text-align: right;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.login_form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'login.php',
                    method: 'POST',
                    dataType: 'JSON',
                    data: $('.login_form').serialize(),
                    success: function(data) {
                        if (data == 'X') {
                            alert('아이디 또는 비밀번호가 틀립니다.');
                        } else {
                            alert('로그인 되었습니다.');
                            console.log(data[0].ip);
                            location.replace('index.php');
                        }
                        
                    }, error: function(e) {
                        alert(e);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php' ?>

    <div class="content_wrapper">
        <h1>로그인 페이지</h1>
        <hr>

        <form action="" class="login_form">
            <table>
                <tr>
                    <th>로그인 폼</th>
                </tr>
                <tr>
                    <td>아이디</td>
                    <td>: <input type="text" name="id" required></td>
                </tr>
                <tr>
                    <td>비밀번호</td>
                    <td>: <input type="password" name="pw" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td id="button_td"><input type="submit" value="로그인"> <button>취소</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>