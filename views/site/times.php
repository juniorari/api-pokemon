<?php

use app\models\Pokemon;
use app\models\PokemonTypes;
use app\models\PokemonSearch;
use app\models\TeamsSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\models\Teams;
use app\models\PokemonTeams;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Times criados';
$this->params['breadcrumbs'][] = $this->title;

$model = new TeamsSearch();
$dataProvider = $model->search(Yii::$app->request->queryParams);

$this->registerJs("
 $('[data-toggle=tooltip]').tooltip({
    container: \"body\",
    html: true,
})
", $this::POS_READY);

?>
<div class="pokemon-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <div class="pokemon-search">

        <?php $form = ActiveForm::begin([
            'action' => ['times'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <div class="row">
            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group col-md-5']]) ?>

            <div class="form-group col-md-2">
                <label class="control-label">&nbsp;</label>
                <?= Html::submitButton('<i class="fa fa-search"></i> Buscar', ['class' => 'btn btn-primary btn-block']) ?>
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
                    'name',
                    [
                        'label' => 'Pokémons',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['nowrap' => 'nowrap', 'class' => 'text-center'],
                        'value' => function ($data) {
                            /** @var Teams $data */
                            $pokes = [];
                            /** @var PokemonTeams $pokemons */
                            foreach ($data->pokemonTeams as $pkteam) {
                                $pokes[] = '<img src="' . $pkteam->pokemon->image . '" width="60" data-toggle="tooltip" data-placement="top" title ="' . $pkteam->pokemon->name . '<br>XP: ' . $pkteam->pokemon->xp . '" />';
                            }
                            return implode("", $pokes);
                        }
                    ]
                ],
            ]); ?>
        </div>
        <?php Pjax::end(); ?>

    </div>
</div>
