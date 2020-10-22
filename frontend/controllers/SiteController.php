<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'comment' => [
                'class' => 'frontend\components\Comment\CommentAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Test page 1.
     */
    public function actionPage1()
    {
        return $this->render('page1', [
            'pageUid' => 1
        ]);
    }

    /**
     * Test page 1.
     */
    public function actionPage2()
    {
        return $this->render('page2', [
            'pageUid' => 2
        ]);
    }
}
