<?php
    $host = 'localhost';
    $user = 'ojh';
    $pw = 'o04118977!';
    $db = 'ojh';

    $conn = mysqli_connect($host, $user, $pw, $db);

    if (!$conn) {
        echo mysqli_connect_error($conn);
    }

    // create table guestbook_user(id varchar(20) primary key, name varchar(10), pw varchar(20));

    // create table guestbook_board(board_id int primary key auto_increment, id varchar(20), board_pw varchar(20), content varchar(1000), ts timestamp default current_timestamp on update current_timestamp, foreign key(id) references guestbook_user(id));

    // create table guestbook_comment(comment_id int primary key auto_increment, id varchar(20), board_id int, ts timestamp default current_timestamp on update current_timestamp, content varchar(1000), foreign key(id) references guestbook_user(id), foreign key(board_id) references guestbook_board(board_id) on delete cascade);
?>