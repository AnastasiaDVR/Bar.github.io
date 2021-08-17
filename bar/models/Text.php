<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text".
 *
 * @property int $id_text
 * @property string $text
 * @property int $tag_text
 *
 * @property Tag $tagText
 */
class Text extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'tag_text'], 'required'],
            [['text'], 'string'],
            [['tag_text'], 'integer'],
            [['tag_text'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_text' => 'id_tag']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_text' => 'Id Text',
            'text' => 'Text',
            'tag_text' => 'Tag Text',
        ];
    }

    /**
     * Gets query for [[TagText]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagText()
    {
        return $this->hasOne(Tag::className(), ['id_tag' => 'tag_text']);
    }
}
