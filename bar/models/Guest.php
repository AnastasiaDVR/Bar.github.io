<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest".
 *
 * @property int $id_guest
 * @property string $name_guest
 * @property int $genre_guest
 * @property int $tag_guest
 *
 * @property Genre $genreGuest
 * @property Tag $tagGuest
 */
class Guest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_guest', 'genre_guest', 'tag_guest'], 'required'],
            [['name_guest'], 'string'],
            [['genre_guest', 'tag_guest'], 'integer'],
            [['genre_guest'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_guest' => 'id_genre']],
            [['tag_guest'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_guest' => 'id_tag']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_guest' => 'Id Guest',
            'name_guest' => 'Name Guest',
            'genre_guest' => 'Genre Guest',
            'tag_guest' => 'Tag Guest',
        ];
    }

    /**
     * Gets query for [[GenreGuest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenreGuest()
    {
        return $this->hasOne(Genre::className(), ['id_genre' => 'genre_guest']);
    }

    /**
     * Gets query for [[TagGuest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagGuest()
    {
        return $this->hasOne(Tag::className(), ['id_tag' => 'tag_guest']);
    }
}
