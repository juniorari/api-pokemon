<?php

namespace app\controllers;

use app\models\PokemonTeams;
use app\models\Teams;
use app\widgets\Utils;
use Yii;

use app\models\Pokemon;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\Controller;


class ApiController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        $behaviors['contentNegotiator'] = [
//            'class' => ContentNegotiator::className(),
//            'formats' => [
//                'application/json' => Response::FORMAT_JSON,
//            ],
//        ];

//        $behaviors['authenticator'] = [
//            'class' => CompositeAuth::class,
//            'authMethods' => [
//                HttpBasicAuth::class,
//                HttpBearerAuth::className(),
//                QueryParamAuth::class,
//            ],
//        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-pokemons'      => ['GET'],
                'save-team'         => ['POST'],
            ],
        ];

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $behaviors;

    }


    public function actionGetPokemons($name = '') {

        try {

            $pokes = Pokemon::find()->select('id, name');
            if ($name) {
                $pokes->andWhere("name LIKE '%{$name}%'");
            }

            return $this->successResponse([
                'pokemons' => $pokes->all(),
            ]);

        } catch (\Exception $e) {
            return $this->errorResponse([
                'error' => $e->getMessage(),
            ], 400);
        }


    }

    public function actionSaveTeam() {

        try {

            $posts = Yii::$app->request->post();

            if (empty($posts['pokemons']) || !is_array($posts['pokemons'])) {
                return $this->errorResponse([
                    'error' => 'Variável "pokemons" é inválida ou inexistente!'
                ], 404);
            }
            if (empty($posts['name'])) {
                return $this->errorResponse([
                    'error' => 'Variável "name" é inválida ou inexistente!'
                ], 404);
            }

            if (!count($posts['pokemons'])) {
                return $this->errorResponse([
                    'error' => 'Por favor, selecione ao menos 1 Pokémon!'
                ], 404);
            }

            if (!count($posts['pokemons']) > Pokemon::POKE_LIMIT) {
                return $this->errorResponse([
                    'error' => 'Por favor, selecione somente ' . Pokemon::POKE_LIMIT . ' Pokémons!'
                ], 400);
            }

            if (strlen($posts['name']) < Pokemon::TEAM_LIMIT) {
                return $this->errorResponse([
                    'error' => 'Informe o nome do Time com ao menos ' . Pokemon::TEAM_LIMIT . ' caracteres!'
                ], 400);
            }


            //verifica se já possui o nome do time cadastrado
            if (Teams::findOne(['name' => $posts['name']])) {
                return $this->errorResponse([
                    'error' => 'Já existe um time com o nome informado. Verifique!'
                ], 400);
            }


            //iniciando a transação, para caso de falha, poder cancelar os dados inseridos
            $t = Yii::$app->db->beginTransaction();

            //salvando o nome do time
            $team = new Teams();

            // Insere o nome do time como maiúsculo no banco
            $team->name = $posts['name'];
            $team->save();

            //definindo os pokemos ao time recém criado
            foreach ($posts['pokemons'] as $pokemon) {
                $pk_team = new PokemonTeams();
                $pk_team->team_id = $team->id;
                $pk_team->pokemon_id = $pokemon;
                $pk_team->save();
            }


            $t->commit();
            return $this->successResponse([
                'message' => 'Time "' . $team->name . '" cadastrado com Sucesso!'
            ]);


        } catch (\Exception $e) {
            $t->rollBack();
            return $this->errorResponse([
                'error' => $e->getMessage(),
            ], 400);
        }
    }



    /**
     * Retorna um json com statusCode com erro.
     * O código de retorno deve estar de acordo com as definições de respostas
     * https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Status
     * @param array $response
     * @param int $code
     * @return array
     */
    protected function errorResponse(array $response, int $code = 400)
    {
        Yii::$app->response->statusCode = $code;
        return $response;
    }

    /**
     * Retorna um json com statusCode com Sucesso código 200
     * @param array $response
     * @return array
     */
    protected function successResponse(array $response)
    {
        Yii::$app->response->statusCode = 200;
        return $response;
    }
}