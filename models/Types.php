<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "types".
 *
 * @property int $id
 * @property string $name
 *
 * @property PokemonTypes[] $pokemonTypes
 */
class Types extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
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
        ];
    }

    /**
     * Gets query for [[PokemonTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPokemonTypes()
    {
        return $this->hasMany(PokemonTypes::className(), ['type_id' => 'id']);
    }
}
