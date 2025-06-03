<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public_info".
 *
 * @property int $id
 * @property string $name
 * @property string $download_path
 * @property string $date
 */
class PublicInfo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'download_path', 'date'], 'required'],
            [['date'], 'safe'],
            [['name', 'download_path'], 'string', 'max' => 255],
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
            'download_path' => 'Download Path',
            'date' => 'Date',
        ];
    }

}
