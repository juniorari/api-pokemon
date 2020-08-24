<?php

namespace app\controllers;

use Yii;

use app\models\Pokemon;

use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\Controller;


class ApiController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];


        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-pokemons'      => ['GET'],
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


            return [
                'pokemons' => $pokes->all(),
            ];


        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 400;
            return [
                'error' => $e->getMessage(),
            ];
        }


    }

}