<?php
namespace frontend\components\Comment;

use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;

class CommentAction extends Action
{
    public function run()
    {
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            throw new BadRequestHttpException();
        }

        $model = new CommentModel();

        if ($model->load($request->post()) && $model->validate()) {
            if ($model->save()) {
                return $this->controller->redirect([$model->redirect]);
            }
            Yii::$app->session->setFlash('error', 'Error while saving comment');
            return $this->controller->redirect([$model->redirect]);
        }

        Yii::$app->session->setFlash('error', 'Something went wrong');
        return $this->controller->redirect([$model->redirect]);
    }
}