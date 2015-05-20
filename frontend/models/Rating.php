<?php

namespace frontend\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $postId
 * @property integer $userId
 * @property integer $rating
 * @property integer $created_at
 * @property integer $updated_at
 */
class Rating extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
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
            [['postId', 'userId'], 'required'],
            [['postId', 'userId', 'created_at', 'updated_at', 'rating'], 'integer']
        ];
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'postId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postId' => 'Post ID',
            'userId' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'rating' => 'Rating'
        ];
    }
}