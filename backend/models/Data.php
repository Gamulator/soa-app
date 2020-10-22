<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Datto\JsonRpc\Evaluator;
use Datto\JsonRpc\Exceptions\MethodException;
use Datto\JsonRpc\Exceptions\ArgumentException;
use yii\db\Expression;

/**
 * Data model
 *
 * @property integer $id
 * @property string $page_uid
 * @property string $author
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Data extends ActiveRecord implements Evaluator
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_uid', 'author', 'content', 'status'], 'required'],
            [['page_uid', 'author'], 'string', 'max' => 255],
            ['content', 'string'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * Parses requests
     */
    public function evaluate($method, $arguments)
    {
        if ($method === 'createComment') {
            return $this->createComment($arguments);
        }

        if ($method === 'getComments') {
            return $this->getComments($arguments);
        }

        throw new MethodException();
    }

    /**
     * Creates a comment
     */
    private function createComment($arguments)
    {
        if (empty($arguments['pageUid']) || empty($arguments['author']) || empty($arguments['content'])) {
            throw new ArgumentException();
        }

        $this->page_uid = $arguments['pageUid'];
        $this->author = $arguments['author'];
        $this->content = $arguments['content'];
        $this->status = self::STATUS_ACTIVE;

        return $this->save(false);
    }

    /**
     * Gets comments list
     */
    private function getComments($arguments)
    {
        if (empty($arguments['pageUid'])) {
            throw new ArgumentException();
        }

        return (new \yii\db\Query())
            ->select('*')
            ->from('data')
            ->where(['page_uid' => $arguments['pageUid']])
            ->orderBy('created_at')
            ->all();
    }
}
