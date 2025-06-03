<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $tittle
 * @property string $about
 * @property string|null $img
 */
class Service extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img'], 'default', 'value' => null],
            [['tittle', 'about'], 'required'],
            [['about'], 'string'],
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
            'about' => 'About',
            'img' => 'Img',
        ];
    }

}
