<?php

/* @var $this yii\web\View */
/* @var $comments array */
/* @var $model CommentModel */

use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>
<div class="comment-widget">

    <h3>Comments</h3>

    <div class="container-fluid">
        <?php if (!empty($comments)) : ?>
            <?php foreach ($comments as $comment) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title"><?= Html::encode($comment['author']) ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted"><?= Yii::$app->formatter->asDate($comment['created_at'], 'long') ?></h6>
                    <?= Html::encode($comment['content']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No comments yet.</p>
        <?php endif; ?>

        <?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax_form']); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'comment-form',
            'class' => 'form-horizontal',
            'action' => ['/site/comment'],
            'options' => [
                'data' => ['pjax' => true],
            ],
        ]); ?>

        <?= $form->field($model, 'pageUid')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'redirect')->hiddenInput(['value' => Yii::$app->controller->route])->label(false) ?>
        <?= $form->field($model, 'author')->input('text')->label('Your name') ?>
        <?= $form->field($model, 'content')->textarea()->label('Your comment') ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>

</div>