<?php

use app\models\Pokemon;
use app\models\PokemonTypes;
use app\models\Types;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%pokemon}}`.
 */
class m200823_022050_create_pokemon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        //tabela com os pokemons
        $this->createTable('{{%pokemon}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->unique(),
            'height' => $this->decimal(5, 2)->notNull(),
            'weight' => $this->decimal(5, 2)->notNull(),
            'xp' => $this->integer(5)->notNull(),
            'image' => $this->string(255)->notNull(),
        ]);


        $this->createIndex(
            'idx-pokemon-name',
            'pokemon',
            'name'
        );


        //tabela de tipos de pokemons
        $this->createTable('{{%types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
        ]);


        //tabela de ligação dos tipos com os pokemons
        $this->createTable('{{%pokemon_types}}', [
            'id' => $this->primaryKey(),
            'pokemon_id' => $this->integer(11)->notNull(),
            'type_id' => $this->integer(11)->notNull(),
        ]);


        $this->createIndex(
            'idx-pokemon_types-pokemon_id',
            'pokemon_types',
            'pokemon_id'
        );


        $this->addForeignKey(
            'fk-pokemon_types-pokemon_id',
            'pokemon_types',
            'pokemon_id',
            'pokemon',
            'id'
        );


        $this->createIndex(
            'idx-pokemon_types-type_id',
            'pokemon_types',
            'type_id'
        );

        $this->addForeignKey(
            'fk-pokemon_types-type_id',
            'pokemon_types',
            'type_id',
            'types',
            'id'
        );

        echo "\n";
        echo "    ============================================================\n";
        echo "       Populando o banco com os dados do JSON. Aguarde...\n";
        echo "    ============================================================\n";
        echo "\n";

        //populando a tabela coms os dados do JSON
        $file = Yii::$app->basePath . "/pokemon.json";
        $content = file_get_contents($file);
        $dados = json_decode($content)->pokemon;
        foreach ($dados as $dado) {

            //Insere, se não existir
            if (!$pk = Pokemon::findOne(['name' => $dado->name])) {
                $pk = new Pokemon();
                $pk->name = $dado->name;
                $pk->height = $dado->height;
                $pk->weight = $dado->weight;
                $pk->xp = $dado->xp;
                $pk->image = $dado->image;
                $pk->save();

                foreach ($dado->types as $type) {
                    if (!$tp = Types::findOne(['name' => $type])) {
                        $tp = new Types();
                        $tp->name = $type;
                        $tp->save();
                    }
                    $pk_tp = new PokemonTypes();
                    $pk_tp->pokemon_id = $pk->id;
                    $pk_tp->type_id = $tp->id;
                    $pk_tp->save();
                }
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pokemon_types}}');
        $this->dropTable('{{%pokemon}}');
        $this->dropTable('{{%types}}');
    }
}
