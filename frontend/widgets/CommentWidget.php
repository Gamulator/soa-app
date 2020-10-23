<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\models\CommentModel;

class CommentWidget extends Widget
{
    public $pageUid;

    private $comments = [];

    public function init()
    {
        parent::init();

        if ($this->pageUid === null) {
            throw new \BadMethodCallException('Undefined page UID');
        }

        $this->comments = CommentModel::getComments($this->pageUid);
    }

    public function run()
    {
        return $this->render('@app/views/comment/widget', [
            'comments' => $this->comments,
            'model' => new CommentModel($this->pageUid)
        ]);
    }
}

