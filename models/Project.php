<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $date
 * @property string|null $img
 */
class Project extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img'], 'default', 'value' => null],
            [['name', 'text', 'date'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['name', 'img'], 'string', 'max' => 255],
            [['imageFile'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'date' => 'Date',
            'img' => 'Img',
        ];
    }

}
