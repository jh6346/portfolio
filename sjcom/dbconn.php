<?php
    $host = 'localhost';
    $user = 'ojh';
    $pw = 'o04118977!';
    $db = 'ojh';

    $conn = mysqli_connect($host, $user, $pw, $db);
    if (!$conn) {
        echo mysqli_connect_error($conn);
        exit;
    }

    //create database ojh;
    //create table member(no int not null auto_increment primary key, name varchar(20), id varchar(20), pw varchar(20), tel varchar(20), email varchar(20), regdate timestamp default current_timestamp, ip int);
    //create table memo(no int not null auto_increment primary key, id varchar(20), name varchar(20), content varchar(1000), regdate timestamp default current_timestamp);
    
    //밑에create table memo_reply(no int not null auto_increment primary key, parent int, id varchar(20), name varchar(20), content varchar(1000), regdate timestamp default current_timestamp, foreign key (parent) references memo(no) on delete cascade, foreign key (id) references member(id));
    //create table memo_reply(no int not null auto_increment primary key, parent int, id varchar(20), name varchar(20), content varchar(1000), regdate timestamp default current_timestamp, foreign key(parent) references memo(no) on delete cascade);

    //밑에create table board(num int auto_increment primary key, id varchar(20), name varchar(20), subject varchar(50), content text, regdate timestamp default current_timestamp, hit int, filename_0 varchar(80), filename_1 varchar(80), filename_2 varchar(80));
    //create table board(num int auto_increment primary key, id varchar(20), name varchar(20), subject varchar(50), content text, regdate timestamp default current_timestamp, hit int, filename_0 varchar(80), filename_1 varchar(80), filename_2 varchar(80), uniqfilename_0 varchar(80), uniqfilename_1 varchar(80), uniqfilename_2 varchar(80));

    //밑에create table download(num int auto_increment primary key, id varchar(20), name varchar(20), subject varchar(50), content text, regdate timestamp default current_timestamp, hit int default 0, filename_0 varchar(80), filename_1 varchar(80), filename_2 varchar(80), filetype_0 varchar(20), filetype_1 varchar(20), filetype_2 varchar(20));
    //create table download(num int auto_increment primary key, id varchar(20), name varchar(20), subject varchar(50), content text, regdate timestamp default current_timestamp, hit int default 0, filename_0 varchar(80), filename_1 varchar(80), filename_2 varchar(80), filetype_0 varchar(20), filetype_1 varchar(20), filetype_2 varchar(20), uniqfilename_0 varchar(80), uniqfilename_1 varchar(80), uniqfilename_2 varchar(80));
?>

