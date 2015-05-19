<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\User;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $slug
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property User $user
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'title', 'slug', 'text'], 'required'],
            [['userId', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getShortText($limit = 250)
    {
        $text = $this->text;
        if(strlen($text) > $limit) {
            $text = substr($text, 0, $limit);
            $text = trim($text);
            return $text . '...';
        } else {
            return $text;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}