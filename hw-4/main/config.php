<?php
const SOL = "b07152d234b79075b9640";

function connect() {
    static $link;
    if (empty($link)) {
        $link = mysqli_connect('localhost', 'root', '', 'gbphp');
    }
    return $link;
}

function clearStr($str) {
    return mysqli_real_escape_string(connect(), strip_tags(trim($str)));
}

function isAdmin(){
    return $_SESSION['isAdmin'] == 'YES';
}

function is_logged() {
  return !empty($_SESSION['login']);
}

function getMsg(){
    $msg = '';
    if (! empty($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        $_SESSION['msg'] = '';
    }
    return  $msg;
}

function getTitle() {
//  $title = false;
  if (!empty($_SESSION['title'])) {
    $title = $_SESSION['title'];
    $_SESSION['title']= '';
  }
  return $title;
}

function template($param = '') {
    static $tmpl;
    if (empty($tmpl)){
        $tmpl = 'public.html';
    }
    if (! empty($param)) {
        $tmpl = $param;
    }
    return $tmpl;
}

function generatePasswordHash($str) {
//  $_SESSION['genPas']=strtoupper(md5())
 return strtoupper(md5($str . SOL));
}

function getCartCountBadge($count) {
  return $count > 0 ? '( ' . $count . ' )' : NULL;
}