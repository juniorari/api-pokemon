<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Acontenceu um erro ao tentar processar sua solicitação
    </p>
    <p>
        Por favor, entre em contato conosco informando o erro acima. Obrigado!
    </p>

</div>
