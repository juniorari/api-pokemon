<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

class ApiController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['pokemons'],
                ],
            ],
        ];
    }


}