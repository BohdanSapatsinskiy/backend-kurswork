<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "about_us".
 *
 * @property int $id
 * @property string $tittle
 * @property string $text
 * @property string|null $img
 */
class AboutUs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_us';
    }


    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img'], 'default', 'value' => null],
            [['tittle', 'text'], 'required'],
            [['text'], 'string'],
            [['tittle', 'img'], 'string', 'max' => 255],
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
            'tittle' => 'Tittle',
            'text' => 'Text',
            'img' => 'Img',
        ];
    }

}
