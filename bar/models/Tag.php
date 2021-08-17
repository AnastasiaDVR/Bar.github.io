<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id_tag
 * @property string $name_tag
 *
 * @property Guest[] $guests
 * @property Text[] $texts
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_tag'], 'required'],
            [['name_tag'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'name_tag' => 'Name Tag',
        ];
    }

    /**
     * Gets query for [[Guests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGuests()
    {
        return $this->hasMany(Guest::className(), ['tag_guest' => 'id_tag']);
    }

    /**
     * Gets query for [[Texts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTexts()
    {
        return $this->hasMany(Text::className(), ['tag_text' => 'id_tag']);
    }
}
