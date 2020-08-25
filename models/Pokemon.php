<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pokemon".
 *
 * @property int $id
 * @property string $name
 * @property float $height
 * @property float $weight
 * @property int $xp
 * @property string $image
 *
 * @property PokemonTypes[] $pokemonTypes
 */
class Pokemon extends \yii\db\ActiveRecord
{

    const POKE_LIMIT = 6;
    const TEAM_LIMIT = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pokemon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'height', 'weight', 'xp', 'image'], 'required'],
            [['height', 'weight'], 'number'],
            [['xp'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'height' => 'Altura',
            'weight' => 'Largura',
            'xp' => 'XP',
            'image' => 'Imagem',
        ];
    }

    /**
     * Gets query for [[PokemonTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPokemonTypes()
    {
        return $this->hasMany(PokemonTypes::className(), ['pokemon_id' => 'id']);
    }
}
