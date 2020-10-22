<?php

/* @var $this yii\web\View */
/* @var $pageUid string */

use frontend\components\Comment\CommentWidget;
use yii\helpers\Html;

$this->title = 'Page 1';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <?= CommentWidget::widget(['pageUid' => $pageUid]) ?>

</div>
