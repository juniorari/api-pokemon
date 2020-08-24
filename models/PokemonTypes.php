<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pokemon_types".
 *
 * @property int $id
 * @property int|null $pokemon_id
 * @property int|null $type_id
 *
 * @property Pokemon $pokemon
 * @property Types $type
 */
class PokemonTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pokemon_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pokemon_id', 'type_id'], 'integer'],
            [['pokemon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pokemon::className(), 'targetAttribute' => ['pokemon_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pokemon_id' => 'Pokemon ID',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * Gets query for [[Pokemon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPokemon()
    {
        return $this->hasOne(Pokemon::className(), ['id' => 'pokemon_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Types::className(), ['id' => 'type_id']);
    }
}
