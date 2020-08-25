<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pokemon_teams".
 *
 * @property int $id
 * @property int $pokemon_id
 * @property int $team_id
 *
 * @property Pokemon $pokemon
 * @property Teams $team
 */
class PokemonTeams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pokemon_teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pokemon_id', 'team_id'], 'required'],
            [['pokemon_id', 'team_id'], 'integer'],
            [['pokemon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pokemon::className(), 'targetAttribute' => ['pokemon_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['team_id' => 'id']],
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
            'team_id' => 'Team ID',
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
     * Gets query for [[Team]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Teams::className(), ['id' => 'team_id']);
    }
}
