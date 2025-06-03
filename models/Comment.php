<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $mark
 * @property string $text
 * @property int $is_correct
 * @property string $date
 *
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_correct'], 'default', 'value' => 0],
            [['user_id', 'mark', 'text', 'date'], 'required'],
            [['user_id', 'mark', 'is_correct'], 'integer'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'mark' => 'Mark',
            'text' => 'Text',
            'is_correct' => 'Is Correct',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
