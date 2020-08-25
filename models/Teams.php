<?php

namespace app\models;

use app\widgets\Utils;
use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property int $id
 * @property string|null $name
 * @property string $updated_at
 * @property string $created_at
 *
 * @property PokemonTeams[] $pokemonTeams
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['name'], 'normalizeValue'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome do Time',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Validando o valor antes de inserir no banco
     * @param $param
     */
    public function normalizeValue($param) {
        $this->$param = Utils::Maiuscula($this->$param);
        $this->$param = Utils::strCorta($this->$param, 50, '');
    }

    /**
     * Gets query for [[PokemonTeams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPokemonTeams()
    {
        return $this->hasMany(PokemonTeams::className(), ['team_id' => 'id']);
    }
}
