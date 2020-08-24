<?php

/* @var $this yii\web\View */

use app\models\Pokemon;

$this->title = "Criar Time";
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("

", $this::POS_READY);
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Forme seu Time de Pokémons</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Buscar Pokémon</label>
                            <div class="form-group input-group">
                                <input type="text" class="form-control" placeholder="Digite ao menos 3 letras para iniciar a buscar">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                                <select multiple="" class="form-control" size="10">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success btn-block"> >> </button>
                            <button class="btn btn-danger btn-block"> << </button>
                            <br>
                        </div>
                        <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                                <select multiple="" class="form-control" size="10">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-lg-9">
                            <div class="form-group">
                                <label>Qual o nome do Time?</label>
                                <input class="form-control" placeholder="Inform aqui o nome do seu time de Pokémons">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button class="btn btn-primary btn-block">Gravar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

</script>