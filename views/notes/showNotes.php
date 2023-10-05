<?php
use yii\helpers\Html;
?>
<h1>Ваши заметки</h1>

<ul>
    <?php foreach($notes as $note):?>
        <li>
            <?='Заголовок: '. $note->head?>
            <?=("<a href=\"index.php?r=notes%2Fdelete-notes&id={$note->id}\"><button>>удалить</button></a></br>")?>
            <?='Заметка: '.$note->note?>
    <?php endforeach;?>
</ul>

