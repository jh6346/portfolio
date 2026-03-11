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
            margin: 50px;
        }
        #button_td {
            text-align: right;
        }
        td span {
            color: red;
            margin-left: 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.idcheck').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'check_id.php',
                    method: 'POST',
                    data: {id: $('#id').val()},
                    success: function(data) {
                        data = $.trim(data);
                        alert(data);
                    },
                    error: function(e) {
                        alert(e);
                    }
                });
            });

            $('.join_form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'insert_user.php',
                    method: 'POST',
                    data: $('.join_form').serialize(),
                    success: function(data) {
                        data = $.trim(data);
                        if (data == 'X') {
                            alert('이미 사용 중인 아이디');
                        } else {
                            alert('가입 완료');
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
    <?php
        include 'header.php';
    ?>

    <div class="content_wrapper">
        <h1>회원가입</h1>
        <hr>
        
        <div class="join">
            <form action="" class="join_form">
                <table>
                    <tr>
                        <th>회원가입 폼</th>
                    </tr>
                    <tr>
                        <td>이름</td>
                        <td>: <input type="text" name="name" required><span>*</span></td>
                    </tr>
                    <tr>
                        <td>아이디</td>
                        <td>: <input type="text" name="id" id="id" required> <button class="idcheck">중복확인</button><span>*</span></td>
                    </tr>
                    <tr>
                        <td>비밀번호</td>
                        <td>: <input type="password" name="pw" required><span>*</span></td>
                    </tr>
                    <tr>
                        <td>전화번호</td>
                        <td>: <input type="tel" name="tel"></td>
                    </tr>
                    <tr>
                        <td>이메일</td>
                        <td>: <input type="email" name="email"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td id="button_td"><input type="submit" value="가입"> <button>취소</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>