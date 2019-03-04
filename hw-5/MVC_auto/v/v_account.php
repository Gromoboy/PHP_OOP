<?php
?>
<h3>Добро пожаловать личный кабинет, <?= $name ?>!</h3>
<p>вы авторезированны под логином <em><big><?= $login ?></big></em></p>
<p>Вы недавно смотрели:</p>
<ul>
  <?= $pageHistory ?>
</ul>
<a href="?c=auth&act=logout">Exit</a
