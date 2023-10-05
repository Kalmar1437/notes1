<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Note;

class NoteForm extends Model
{

    public $head;
    public $note;
    // public $date;

    public function rules(){
        return [
            [['head','note'],'required'],
        ];
    }


    public function add()
    {
        $note = new Note();
        $note->head = $this->head;
        $note->note = $this->note;
        $note->userId = Yii::$app->user->getId();

        $note->save();

    }
}