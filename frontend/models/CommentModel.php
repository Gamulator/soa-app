<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use GuzzleHttp\Client;

/**
 * CommentModel model
 */
class CommentModel extends Model
{
    public $pageUid;
    public $author;
    public $content;
    public $redirect;

    public function __construct($pageUid = 0, $config = [])
    {
        $this->pageUid = $pageUid;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pageUid', 'author', 'content'], 'required'],
            [['pageUid', 'author'], 'string', 'max' => 255],
            ['content', 'string'],
            ['redirect', 'safe'],
        ];
    }

    public static function getComments($pageUid)
    {
        $jsonRpcClient = new \Datto\JsonRpc\Client();
        $jsonRpcClient->query(1, 'getComments', ['pageUid' => $pageUid]);

        $jsonRpcMessage = $jsonRpcClient->encode();

        try {
            $httpClient = new Client([
                'base_uri' => Yii::$app->params['rpcServer']
            ]);
            $response = $httpClient->request('POST', '/site/api', ['body' => $jsonRpcMessage]);

            $jsonRpcResponse = $response->getBody()->getContents();
            $data = json_decode($jsonRpcResponse, true);

            if (isset($data['result']) && is_array($data['result'])) {
                return $data['result'];
            }

            return [];

        } catch (\Throwable $e) {
            // можно тут как-то фиксировать ошибку для отображения
            return [];
        }
    }

    public function save()
    {
        $jsonRpcClient = new \Datto\JsonRpc\Client();
        $jsonRpcClient->query(1, 'createComment', [
            'pageUid' => $this->pageUid,
            'author' => $this->author,
            'content' => $this->content
        ]);

        $jsonRpcMessage = $jsonRpcClient->encode();

        try {
            $httpClient = new Client([
                'base_uri' => Yii::$app->params['rpcServer']
            ]);
            $response = $httpClient->request('POST', '/site/api', ['body' => $jsonRpcMessage]);

            $jsonRpcResponse = $response->getBody()->getContents();
            $data = json_decode($jsonRpcResponse, true);

            if (isset($data['result'])) {
                return $data['result'];
            }

            return false;

        } catch (\Throwable $e) {
            return false;
        }
    }
}
