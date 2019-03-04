<?php
// Шаблон авторизации
?>

<form method="post" action="index.php?c=auth&act=auth">
    <input type="text" name="login" placeholder="login">
    <input type="text" name="password" placeholder="password">
    <input type="submit">
</form>
<hr>
<br>
<small>Если у вас нет логина на нашем сайте,</small>
<a class="ref" href="?c=auth&func=reg">
    <b>зарегистрируйтесь ...</b>
</a>
<p class="error" style="color:red;"><?=$error?></p>