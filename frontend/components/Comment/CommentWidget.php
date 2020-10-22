<?php

namespace frontend\components\Comment;

use Yii;
use yii\base\Widget;

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
        return $this->render('widget', [
            'comments' => $this->comments,
            'model' => new CommentModel($this->pageUid)
        ]);
    }
}

