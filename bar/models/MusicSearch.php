<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Music;

/**
 * MusicSearch represents the model behind the search form of `app\models\Music`.
 */
class MusicSearch extends Music
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_music', 'genre_music'], 'integer'],
            [['name_music'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Music::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_music' => $this->id_music,
            'genre_music' => $this->genre_music,
        ]);

        $query->andFilterWhere(['like', 'name_music', $this->name_music]);

        return $dataProvider;
    }

    public function getMusic()
    {
        $arrayMusic = Music::find()
            ->select('name_music')
            ->distinct()
            ->asArray()
            ->all();

        $randomMusic = array_rand($arrayMusic, 1);

        $query = Music::find()
            ->select('name_music')
            ->where(['id_music' => $arrayMusic[$randomMusic]])
            ->one();

        // $arrayGenre = Music::find()
        //     ->select('name_genre')
        //     ->with('genreMusic')
        //     ->innerjoin('genre', '`id_genre` = `genre_music`')
        //     ->where(['name_music' => $arrayMusic[$randomMusic]])
        //     ->asArray()
        //     ->all();

        $randMusic = $arrayMusic[$randomMusic];
        return $randMusic;
    }
}
