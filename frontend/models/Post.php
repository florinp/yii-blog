<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\User;
use yii\helpers\VarDumper;

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
 *
 * @property User $user
 * @property Comment[] $comments
 * @property Rating[] $ratings
 * @property integer $rating
 */
class Post extends ActiveRecord
{
    public $rating;
    public $thumbnail;

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

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['postId' => 'id'])->orderBy("created_at DESC");
    }

    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['postId' => 'id']);
    }

    /**
     * Returns the post rating
     * @return int post rating
     */
    public function getRating()
    {
        $ratings = $this->ratings;
        $allRatings = 0;

        if(count($ratings)) {
            foreach($ratings as $rating) {
                $allRatings = $allRatings + $rating->rating;
            }
            $this->rating = ($allRatings / count($ratings));
        }

        //VarDumper::dump($this->rating, 10, true);

        return (int)$this->rating;
    }

    /**
     * Checks if the user has rated the post
     * @return bool true if the user has rated and false otherwise
     */
    public function checkRating()
    {
        if(!Yii::$app->user->isGuest) {
            $rating = Rating::find()
                ->where("postId = :postId",[":postId" => $this->id])
                ->andWhere("userId = :userId", [":userId" => Yii::$app->user->getId()]);

            if($rating->count() > 0) {
                return false;
            } else {
                return true;
            }

        } else {
            return false;
        }

        return false;
    }

    /**
     * Returns a shorter version of the post body
     * @param int $limit chars limit
     * @return string
     */
    public function getShortText($limit = 250)
    {
        $text = $this->text;

        // remove images from text
        $text = preg_replace('/<img[^>]+\>/', "", $text);

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