<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Data;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * Homepage for information
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * API endpoint
     */
    public function actionApi()
    {
        $request = Yii::$app->request;
        $message = $request->rawBody;

        $server = new \Datto\JsonRpc\Server(new Data());

        return $server->reply($message);
    }

}
