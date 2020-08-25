<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pokemon;

/**
 * PokemonSearch represents the model behind the search form of `app\models\Pokemon`.
 */
class PokemonSearch extends Pokemon
{

    public $tipo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'xp'], 'integer'],
            [['name', 'image'], 'safe'],
            [['height', 'weight'], 'number'],
            [['tipo'], 'string']
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
        $query = Pokemon::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'tipo' => [
                        'asc' => [Types::tableName() . '.desc' => SORT_ASC],
                        'desc' => [Types::tableName() . '.desc' => SORT_DESC],
                        'default' => SORT_ASC
                    ],
                    'id', 'name', 'height', 'weight', 'xp',
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->innerJoin(PokemonTypes::tableName(). ' pkt', 'pokemon.id = pkt.pokemon_id');
        $query->innerJoin(Types::tableName(), 'types.id = pkt.type_id');


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'height' => $this->height,
            'weight' => $this->weight,
            'xp' => $this->xp,
        ]);

        $query->andFilterWhere(['like', 'pokemon.name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'types.name', $this->tipo]);

        return $dataProvider;
    }
}
