<?php include 'lib.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        
    </style>
    <script>
        function guest_select() {
            $('.memo_list').empty();
            $.ajax({
                url: 'guest_select.php',
                dataType: 'JSON',
                success: function(data) {
                    $.each(data, function(i, o) {
                        var board_header = $('<div />').append(
                            $('<p />').append(o.no).addClass('board_no'),
                            $('<p />').append(o.name).addClass('board_name'),
                            $('<p />').append(o.regdate).addClass('board_regdate')
                        ).addClass('board_header');

                        if (o.id == user_id) {
                            board_header.append($('<button />').append('삭제').addClass('board_delete'));
                        }

                        var board_content = $('<div />').append(o.content).addClass('board_content');


                        var reply_list = $('<div />').append().addClass('reply_list');

                        $.ajax({
                            url: 'guest_reply_select.php',
                            method: 'POST',
                            data: {no: o.no},
                            dataType: 'JSON',
                            success: function(rdata) {
                                $.each(rdata, function(ri, ro) {
                                    var reply_header = $('<div />').append(
                                        $('<p />').append(ro.no).addClass('reply_no'),
                                        $('<p />').append(ro.name).addClass('reply_name'),
                                        $('<p />').append(ro.regdate).addClass('reply_regdate')
                                    ).addClass('reply_header');

                                    if (ro.id == user_id) {
                                        reply_header.append($('<button />').append('삭제').addClass('reply_delete'));
                                    }

                                    var reply_content = $('<div />').append(ro.content).addClass('reply_content');

                                    var reply = $('<div />').append(reply_header, reply_content).addClass('reply');

                                    reply_list.append(reply);
                                });
                            }, error: function(e) {
                                alert(e);
                            }
                        });


                        reply_input = $('<div />').append(
                            $('<textarea />', {
                                class: 'reply_textarea',
                                name: 'reply_textarea'
                            }).append(),
                            $('<button />').append('댓글입력').addClass('reply_submit')
                        ).addClass('reply_input');

                        replys = $('<div />').append(reply_list, reply_input).addClass('replys');

                        // console.log(reply_list);
                        var board = $('<div />').append(board_header, board_content, replys).addClass('board');

                        $('.memo_list').append(board);
                    });
                }, error: function(e) {
                    alert(e);
                }
            });
        }

        $(document).ready(function() {
            if (user_id) {
                $('.user_name').html('<?php if(isset($_SESSION['user_info'])) {echo $_SESSION['user_info']['name'];} ?>');
            }
            guest_select();

            // 방명록 입력
            $('.memo_form').on('submit', function(e) {
                e.preventDefault();

                if (user_id) {
                    $.ajax({
                        url: 'guest_insert.php',
                        method: 'POST',
                        data: $('.memo_form').serialize(),
                        success: function(data) {
                            guest_select();
                            $('.memo_form textarea').val('');
                        }, error: function(e) {
                            alert(e);
                        }
                    })
                } else {
                    alert('로그인 후 사용하세요.');
                }
            });

            // 방명록 삭제
            var target_board_no;
            $(document).on('click', '.board_delete', function(e) {
                target_board_no = $(this).prevAll('.board_no').html();
                $('.board_delete_modal').show();
            });
            $('.board_delete_btn .yes').on('click', function() {
                $.ajax({
                    url: 'guest_delete.php',
                    method: 'POST',
                    data: {no: target_board_no},
                    success: function(data) {
                        data = $.trim(data);
                        alert(data);
                        $('.board_delete_modal').hide();
                        guest_select();
                    }, error: function(e) {
                        alert(e);
                    }
                });
            });
            $('.board_delete_btn .no').on('click', function() {
                $('.board_delete_modal').hide();
            });
            

            // 댓글 입력
            $(document).on('click', '.reply_submit', function() {
                if (user_id) {
                    target_board_no = $(this).parents('.board').find('.board_no').html();
                    if ($(this).prev().val() == '') {
                        alert('입력란이 비어있습니다.');
                    } else {
                        $.ajax({
                            url: 'guest_reply_insert.php',
                            method: 'POST',
                            data: {parent_no: target_board_no, content: $(this).prev().val()},
                            success: function(data) {
                                $(this).prev().val('');
                                guest_select();
                            }, error: function(e) {
                                alert(e);
                            }
                        });
                    }
                } else {
                    alert('로그인 후 사용하세요.');
                }
                
            });

            //댓글 삭제
            $(document).on('click', '.reply_delete', function() {
                target_board_no = $(this).prevAll('.reply_no').html();
                $('.reply_delete_modal').show();
            });

            $('.reply_delete_btn .yes').on('click', function() {
                $.ajax({
                    url: 'guest_reply_delete.php',
                    method: 'POST',
                    data: {no: target_board_no},
                    success: function(data) {
                        data = $.trim(data);
                        $('.reply_delete_modal').hide();
                        alert(data);
                        guest_select();
                    }, error: function(e) {
                        alert(e);
                    }
                });
            });
            $('.reply_delete_btn .no').on('click', function() {
                $('.reply_delete_modal').hide();
            });
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="content">
        <div class="memo">
            작성자: <span class="user_name"></span>
            <form action="" class="memo_form">
                <textarea name="content" id="content" required></textarea>
                <input type="submit" value="메모하기">
            </form>
        </div>

        <hr>

        <div class="memo_list">
            <div class="board">
                <div class="board_header">
                    <p class="board_no">1</p>
                    <p class="board_name">name</p>
                    <p class="board_regdate">regdate</p>
                    <button class="board_delete">삭제</button>
                </div>
                <div class="board_content">
                    content
                </div>

                <div class="replys">
                    <div class="reply_list">
                        <div class="reply">
                            <div class="reply_header">
                                <p class="reply_no">no</p>
                                <p class="reply_name">name</p>
                                <p class="reply_regdate">regdate</p>
                                <button class="reply_delete">삭제</button>
                            </div>
                            <div class="reply_content">
                                content
                            </div>
                        </div>
                    </div>

                    ...

                    <div class="reply_input">
                        <textarea name="reply_textarea" id="reply_textarea"></textarea>
                        <button class="reply_submit">댓글입력</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="board_delete_modal delete_modal">
            <div class="board_delete_content delete_content">
                <p>방명록을 삭제합니다.</p>
                <div class="board_delete_btn">
                    <button class="yes">YES</button>
                    <button class="no">NO</button>
                </div>
            </div>
        </div>

        <div class="reply_delete_modal delete_modal">
            <div class="reply_delete_content delete_content">
                <p>댓글을 삭제합니다.</p>
                <div class="reply_delete_btn">
                    <button class="yes">YES</button>
                    <button class="no">NO</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>