<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var user_id = "<?php echo isset($_SESSION['user_id'])?$_SESSION['user_id']:'';?>";

        //board_select
        function board_select() {
            $('#board').empty();

            $.ajax({
                url: 'board_select.php',
                dataType: 'JSON',
                success: function(data) {
                    $.each(data, function(i, o) { //board
                        if (user_id == o.id) {
                            var row = $('<div />').append(
                                $('<div />').append(
                                    $('<span />').append(o.board_id).addClass('board_num'),
                                    $('<span />').append(o.name).addClass('board_name'),
                                    $('<span />').append(o.ts).addClass('board_ts'),
                                    $('<button />').append('수정').addClass('modify'),
                                    $('<button />').append('삭제').addClass('delete'),
                                ).addClass('board_header'),
                                '<hr>',
                                $('<p />').append(o.content).addClass('board_content')
                            ).addClass('board_wrapper');
                        } else {
                            var row = $('<div />').append(
                                $('<div />').append(
                                    $('<span />').append(o.board_id).addClass('board_num'),
                                    $('<span />').append(o.name).addClass('board_name'),
                                    $('<span />').append(o.ts).addClass('board_ts')
                                ).addClass('board_header'),
                                '<hr>',
                                $('<p />').append(o.content).addClass('board_content')
                            ).addClass('board_wrapper');
                        }
                        
                        var comment_input = $('<div />').append( //comment input
                            $('<form />').append(
                                    '<hr>',
                                    $('<textarea />', {
                                        name: 'comment',
                                        cols: 60,
                                        rows: 3,
                                        required: true
                                    }).addClass('comment_textarea'),
                                    $('<input />', {
                                        type: 'submit',
                                        value: '댓글입력'
                                    })
                            ).addClass('comment_form')
                        ).addClass('comment_input');

                        var comment_list = $('<div />').addClass('comment_list');
                        var comment = $('<div />').append(comment_list, comment_input).addClass('comment');

                        row.append(comment);
                        $('#board').append(row);

                        //comment_select
                        $.ajax({
                            url: 'comment_select.php',
                            method: 'POST',
                            data: {board_id: o.board_id},
                            dataType: 'JSON',
                            success: function(data) {
                                $.each(data, function(c_i, c_o) {
                                    var comment_header = $('<div />').append(
                                            $('<div />').append().addClass('dot'),
                                            $('<span />').append(c_o.name).addClass('comment_name'),
                                            $('<span />').append(c_o.ts).addClass('comment_ts')
                                        ).addClass('comment_header');

                                    if (c_o.id == user_id) { //comment delete
                                        comment_header.append(
                                            $('<button />', {
                                                name: c_o.comment_id
                                            }).append('삭제').addClass('comment_delete')
                                        );
                                    }

                                    var comment_wrapper = $('<div />').append(
                                        comment_header,
                                        $('<div />').append(c_o.content).addClass('comment_content')
                                    ).addClass('comment_wrapper');

                                    comment_list.append(comment_wrapper);
                                });
                            }, error: function(e) {
                                alert(e);
                            }
                        });
                        // $('#board').append(row);
                    });
                }, error: function() {
                    alert('error');
                }
            });
        }

        function comment_select() {

        }

        $(document).ready(function() {       
            // <?php
            //     session_start();

            //     if(isset($_SESSION['user_id'])) {
            //         echo "$('.login').css('display', 'none');";
            //         echo "$('#name').text('" . $_SESSION['user_id'] . "');";
            //     } else {
            //         echo "$('.logout').css('display', 'none');";
            //     }
            // ?>
            //session
            if (user_id) {
                $('.login').hide();
                $('#name').text(user_id);
            } else {
                $('.logout').hide();
            }
            
            board_select();

            //login
            $('.login').on('click', function() {
                location.replace('login.html');
            });

            $('.signup').on('click', function() {
                location.replace('signup.html');
            });

            // logout
            $('.logout').on('click', function() {
                location.replace('logout.php');
            });

            //board insert
            $('.board').on('submit', function(e) {
                e.preventDefault();

                if (user_id) {
                    $.ajax({
                        url: 'board_insert.php',
                        method: 'POST',
                        data: $('.board').serialize(),
                        success: function(data) {
                            alert(data);
                            $('#pw').val('');
                            $('#text').val('');
                            board_select();
                        }, error: function(e) {
                            alert(e);
                        }
                    });
                } else {
                    alert('로그인을 해주세요.');
                }
                
            });

            //board pw check close
            $('.board_pw_ck .close').on('click', function(e) {
                e.preventDefault();
                $('.board_pw_ck').hide();
            });
            

            var target_board_id;
            //board modify
            $(document).on('click', '.modify', function(e) {
                e.preventDefault();
                console.log('a');
                $('.board_pw_ck_modify').show();
                target_board_id = $(this).prevAll('.board_num').html();

                
                // $('.modify_modal').show();
            });

            $('.board_pw_form_modify .submit').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'board_delete.php',
                    method: 'POST',
                    data: {board_pw: $('#board_pw_modify').val(), board_id: target_board_id, type: 'modify'},
                    success: function(data) {
                        $('#board_pw_modify').val('');

                        if (data=='O') {
                            $('.modify_modal').show();
                            $('.board_pw_ck').hide();
                        }
                    }, error: function() {
                        alert('error');
                    }
                });
            });

            $('.modify_board').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'board_modify.php',
                    method: 'POST',
                    data: {board_id: target_board_id, content: $('#modify_text').val()},
                    success: function(data) {
                        alert(data);

                        if (data=='O') {
                            board_select();
                            
                            $('#modify_text').val('');
                            $('.modify_modal').hide();
                        }
                    }, error: function() {
                        alert('error');
                    }
                });
            });

            $('.modify_modal .close').on('click', function(e) {
                e.preventDefault();
                $('.modify_modal').hide();
            });

            
            //board delete
            $(document).on('click', '.delete', function() {
                $('.board_pw_ck_delete').show();
                target_board_id = $(this).prevAll('.board_num').html();
            });

            $('.board_pw_form_delete .submit').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'board_delete.php',
                    method: 'POST',
                    data: {board_pw: $('#board_pw_delete').val(), board_id: target_board_id, type: 'delete'},
                    success: function(data) {
                        alert(data);
                        $('#board_pw_delete').val('');

                        if (data=='O') {
                            $('.board_pw_ck').hide();
                            board_select();
                        }
                    }, error: function() {
                        alert('error');
                    }
                });
            });


            // comment insert
            $(document).on('submit', '.comment_form', function(e) {
                e.preventDefault();

                if (!user_id) {
                    alert('로그인을 해주세요.');
                } else {
                    var board_id = $(this).closest('.board_wrapper').find('.board_num').text();
                    var content = $(this).find('textarea').val();

                    $.ajax({
                        url: 'comment_insert.php',
                        method: 'POST',
                        data: {board_id: board_id, content: content},
                        success: function(data) {
                            alert(data);
                            board_select();
                        }, error: function() {
                            alert('error');
                        }
                    });
                }
            });

            //comment delete
            $(document).on('click', '.comment_delete', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'comment_delete.php',
                    method: 'POST',
                    data: {comment_id: $(this).attr('name')},
                    success: function(data) {
                        alert(data);
                        if (data == 'O') {
                            board_select();
                        }
                    }, error: function() {
                        alert('error');
                    }
                })
            })

        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="user">
            <span class="login">로그인</span>&nbsp;&nbsp;
            <span class="logout">로그아웃</span>&nbsp;&nbsp;
            <span class="signup">회원가입</span>&nbsp;
        </div>

        <div class="header">
            <p>방명록</p>
        </div>

        <div class="content">
            <form action="" class="board">
                <p class="top">
                    <span class="name">이름: <span id="name"></span></span>
                    <span class="pw">비밀번호: <input type="password" name="pw" id="pw" required></span>
                </p>

                <textarea name="text" id="text" cols="80" rows="10" placeholder="내용을 입력하세요." required></textarea>

                <br>

                <input type="submit" value="저장" class="submitbtn">
            </form>
        </div>

        <div id="board">
            <div class="board_wrapper">
                <div class="board_header">
                    <span class="board_num">1</span>
                    <span class="board_name">name</span>
                    <span class="board_ts">ts</span>
                    <button class="modify">수정</button>
                    <button class="delete">삭제</button>
                </div>
                <hr>
                <p class="board_content">content</p>

                <div class="comment">
                    <div class="comment_list">
                        <div class="comment_wrapper">
                            <div class="comment_header">
                                <div class="dot"></div>
                                <span class="comment_name">name</span>
                                <span class="comment_ts">1</span>
                                <button class="comment_delete">삭제</button>
                            </div>

                            <div class="comment_content">content</div>
                        </div>
                    </div>
                    <hr>
                    <div class="comment_input">
                        <form action="" class="comment_form">
                            <textarea name="comment" id="comment_textarea" cols="60" rows="3" required></textarea>
                            <input type="submit" value="댓글입력">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="board_pw_ck_delete board_pw_ck">
            <div class="board_pw_ck_content_delete board_pw_ck_content">
                <form action="" class="board_pw_form_delete board_pw_form">
                    <input type="password" name="board_pw_delete" id="board_pw_delete" placeholder="비밀번호 입력">
                    <button class="submit">확인</button>
                    <button class="close">닫기</button>
                </form>
            </div>
        </div>
        
        <div class="board_pw_ck_modify board_pw_ck">
            <div class="board_pw_ck_content_modify board_pw_ck_content">
                <form action="" class="board_pw_form_modify board_pw_form">
                    <input type="password" name="board_pw_modify" id="board_pw_modify" placeholder="비밀번호 입력">
                    <button class="submit">확인</button>
                    <button class="close">닫기</button>
                </form>
            </div>
        </div>

        <div class="modify_modal">
            <div class="modify_modal_content">
                <form action="" class="modify_board">
                    <textarea name="modify_text" id="modify_text" cols="80" rows="10" placeholder="내용을 입력하세요." required></textarea>

                    <br>

                    <input type="submit" value="저장">
                    <button class="close">닫기</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>



