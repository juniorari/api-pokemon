<?php

/* @var $this yii\web\View */

use app\models\Pokemon;

$this->title = Yii::$app->name;

?>
    <div class="site-index">

        <div class="text-center">
            <h2>Bem vindo a Api Pokémon!</h2>
        </div>

        <div class="container-fluid">

            <div class="row">
                <?php
                $pks = Pokemon::find()->orderBy('rand()')->limit(12)->all();
                /** @var Pokemon $pok */
                foreach ($pks as $idx => $pok) {
                    ?>
                    <div class="col-sm-3 text-center">
                        <div class="hero-widget  well-sm">
                            <div class="icon">
                                <img src="<?= $pok->image ?>" class="img-thumbnail img-responsive"
                                     style="max-width: 100px; width: 100px" title="Pokémon <?= $pok->name ?>">
                            </div>
                            <div class="text">
                                <label class="text-muted"><?= $pok->name ?></label>
                            </div>
                            <small>XP: <span class="value"><?= $pok->xp ?></span></small>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>

            <div class="text-right">e muito mais...</div>

        </div>
    </div>
    <script>
        function requestData() {
            $.post({
                url: 'get-data',
                type: 'post',
                dataType: 'json'
            }, function (data) {
                console.log(data);
            })
        }

    </script>

<?php
