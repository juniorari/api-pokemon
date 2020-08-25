<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teams}}`.
 */
class m200824_230625_create_teams_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%teams}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->unique(),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);


        $this->createIndex(
            'idx-teams-name',
            'teams',
            'name'
        );


        //tabela de ligação dos tipos com os pokemons
        $this->createTable('{{%pokemon_teams}}', [
            'id' => $this->primaryKey(),
            'pokemon_id' => $this->integer(11)->notNull(),
            'team_id' => $this->integer(11)->notNull(),
        ]);


        $this->createIndex(
            'idx-pokemon_teams-pokemon_id',
            'pokemon_teams',
            'pokemon_id'
        );

        $this->addForeignKey(
            'fk-pokemon_teams-pokemon_id',
            'pokemon_teams',
            'pokemon_id',
            'pokemon',
            'id'
        );


        $this->createIndex(
            'idx-pokemon_teams-team_id',
            'pokemon_teams',
            'team_id'
        );

        $this->addForeignKey(
            'fk-pokemon_teams-team_id',
            'pokemon_teams',
            'team_id',
            'teams',
            'id'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pokemon_teams-team_id', 'pokemon_teams');
        $this->dropIndex('idx-pokemon_teams-team_id', 'pokemon_teams');
        $this->dropForeignKey('fk-pokemon_teams-pokemon_id', 'pokemon_teams');
        $this->dropIndex('idx-pokemon_teams-pokemon_id', 'pokemon_teams');
        $this->dropTable('{{%pokemon_teams}}');

        $this->dropTable('{{%teams}}');
    }
}
