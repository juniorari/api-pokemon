<?php

use app\models\Pokemon;
use app\models\PokemonTypes;
use app\models\PokemonSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pokémons';
$this->params['breadcrumbs'][] = $this->title;

$model = new PokemonSearch();
$dataProvider = $model->search(Yii::$app->request->queryParams);


?>
<div class="pokemon-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <div class="pokemon-search">

        <?php $form = ActiveForm::begin([
            'action' => ['pokemons'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <div class="row">
            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group col-md-5']]) ?>
            <?= $form->field($model, 'tipo', ['options' => ['class' => 'form-group col-md-3']]) ?>

            <div class="form-group col-md-2">
                <label class="control-label">&nbsp;</label>
                <?= Html::submitButton('<i class="fa fa-search"></i> Buscar', ['class' => 'btn btn-primary btn-block', 'name' => 'search-pokemon']) ?>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label">&nbsp;</label>
                <?= Html::a('Limpar', ['pokemons'], ['class' => 'btn btn-default btn-block']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
        <div class="box-body table-responsive no-padding">

            <?php

            $dataProvider->pagination->pageSize = 10;
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'image',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center', 'style' => 'width: 100px'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($data) {
                            return Html::img($data->image, ['width' => '45']);
                        }
                    ],
                    'name',
//                    'height',
//                    'weight',
                    'xp',
                    [
                        'label' => 'Tipos',
                        'format' => 'raw',
                        'value' => function ($data) {
                            /** @var Pokemon $data */
                            $tipos = [];
                            /** @var PokemonTypes $types */
                            foreach ($data->pokemonTypes as $types) {
                                $tipos[] = $types->type->name;
                            }
                            return implode(" / ", $tipos);
                        }
                    ]
                ],
            ]); ?>
        </div>
        <?php Pjax::end(); ?>

    </div>
</div>
