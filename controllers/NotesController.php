<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\NoteForm;
use app\models\Note;

class NotesController extends Controller
{


    public function actionRenderNoteForm()
    {
        $model = new NoteForm();

        if($model->load(Yii::$app->request->post())){
            $model->add();
        }

        return $this->render('NoteFormView', ['model'=>$model]);    
    }


    public function actionShowNotes()
    {   
        $Notes = Note::find()->where(['userId'=>Yii::$app->user->getId()])->all();
        return $this->render('showNotes',['notes'=>$Notes]);
    }

    public function actionDeleteNotes($id)
    {
        Note::deleteNote(id);
        return $this->goBack();
    }





}