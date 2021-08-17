<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Guest;
use yii\helpers\ArrayHelper;

/**
 * GuestSearch represents the model behind the search form of `app\models\Guest`.
 */
class GuestSearch extends Guest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_guest', 'genre_guest', 'tag_guest'], 'integer'],
            [['name_guest'], 'safe'],
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
        $query = Guest::find();

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
            'id_guest' => $this->id_guest,
            'genre_guest' => $this->genre_guest,
            'tag_guest' => $this->tag_guest,
        ]);

        $query->andFilterWhere(['like', 'name_guest', $this->name_guest]);

        return $dataProvider;
    }

    public function getGuest()
    {
        $dataGenre = Genre::find()
            ->asArray()
            ->all();
        // $dataGenre = ArrayHelper::getColumn($dataGenre, 'id_genre');
        $dataGenre = ArrayHelper::index($dataGenre, 'id_genre');

        $randGuest = rand(1, 10); 

        Guest::deleteAll();

        // $command = Yii::$app->db->truncateTable('guest')->execute();

        for ($i=1; $i < $randGuest+1; $i++) { 

            // Считаем сколько жанров и выбираем сколько будет жанров
            $randCountGenre = count($dataGenre);
            if ($randCountGenre > 0) {
                $randCountGenre = rand(1, $randCountGenre);
                
                //  выбираем случайные жанры из списка (массив, количество)
                $randGenre = array_rand($dataGenre, $randCountGenre);
                
                // Для каждого жанра в списке создаём запись гостя, имя гостя - текущий счётчик. По умол. все в баре
                if ($randCountGenre > 1) {
                    // foreach ($randGenre as $key => $value) {
                    //     $query = Guest::insert('guest', array(
                    //         'name_guest' => 'Guest'.$i,
                    //         // 'genre_guest' => $dataGenre[$value],
                    //         'tag_guest' => 1,
                    //         ));
                    // }
                }else{
                    // $val = ArrayHelper::getValue($dataGenre, $randGenre);
                    // $query = Guest::insert('guest', array(
                    //     'name_guest' => 'Guest'.$i,
                    //     'genre_guest' => $dataGenre,
                    //     'tag_guest' => 1,
                    //     ));
                }
            }   
                
        }

        // $randMusic = array_rand($arrayMusic, 1);

        // $query = Music::find()
        //     ->select('name_music')
        //     ->where(['id_music' => $arrayMusic[$randMusic]])
        //     ->one();

        return $dataGenre;
    }
}
