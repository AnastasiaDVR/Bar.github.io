<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "music".
 *
 * @property int $id_music
 * @property string $name_music
 * @property int $genre_music
 *
 * @property Genre $genreMusic
 */
class Music extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_music', 'genre_music'], 'required'],
            [['name_music'], 'string'],
            [['genre_music'], 'integer'],
            [['genre_music'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_music' => 'id_genre']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_music' => 'Id Music',
            'name_music' => 'Name Music',
            'genre_music' => 'Genre Music',
        ];
    }

    /**
     * Gets query for [[GenreMusic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenreMusic()
    {
        return $this->hasOne(Genre::className(), ['id_genre' => 'genre_music']);
    }
}
