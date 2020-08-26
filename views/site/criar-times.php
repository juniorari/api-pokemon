<?php

/* @var $this yii\web\View */

use app\models\Pokemon;
use yii\helpers\Url;
use kartik\dialog\Dialog;

$this->title = "Criar Time";
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
#poke-selected-val {
    font-weight: bold;
}
#team-name {
    text-transform: uppercase;
}
");

//inicia a função para buscar e preencher o select com os pokemons disponiveis
$this->registerJs('searchPokemon();', $this::POS_READY);

// Widget Dialog com as opções default
echo Dialog::widget([
    'libName' => 'alertDanger',
    'options' => [
        'type' => Dialog::TYPE_DANGER,
        'title' => 'Erro',
    ]
]);
echo Dialog::widget([
    'libName' => 'alertSuccess',
    'options' => [
        'type' => Dialog::TYPE_SUCCESS,
        'title' => 'Sucesso',
    ]
]);
//o alerta para a confirmação
echo Dialog::widget();
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Forme seu Time de Pokémons</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5 col-lg-5">
                            <label>Buscar Pokémon</label>
                            <div class="form-group input-group">
                                <input type="text" onkeyup="delaykey('searchPokemon()', 600)" class="form-control"
                                       id="poke-search" placeholder="Digite para iniciar a buscar...">
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
                                <select multiple="" class="form-control" id="poke-available" size="10">
                                    <option>Nenhum registro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success btn-block disabled" id="btn-add" onclick="pokeAdd()"><i class="fa fa-chevron-right"></i></button>
                            <button class="btn btn-danger btn-block disabled" id="btn-remove" onclick="pokeRemove()"><i class="fa fa-chevron-left"></i></button>
                            <br>
                        </div>
                        <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                                <select class="form-control" id="poke-selected" size="10">
                                    <option value="">Nenhum Pokémon selecionado</option>
                                </select>
                                <small>Selecionados <span id="poke-selected-val">0</span> Pokémons</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                                <label>Qual o nome do Time?</label>
                                <input class="form-control" maxlength="50" id="team-name">
                                <small class="help-block">Informe aqui o nome do seu time de Pokémons</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" id="btn-save" onclick="saveTeam()"><i
                                            class="fa fa-save"></i> Gravar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>

    // O limite de pokemons que pode ser adicionado
    let POKE_LIMIT = <?=Pokemon::POKE_LIMIT?>;
    // A quantidade de caracteres mínimo para o nome do time
    let TEAM_LIMIT = <?=Pokemon::TEAM_LIMIT?>;
    // Os pokemons adicionados
    let POKEMONS = [];


    // Criado uma função para dar um delay na digitação no input de busca dos pokemons
    // Isso evita que não seja consumida a API a cada vez que for pressionada uma tecla para busca,
    let delaykey = function () {
        let timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    }();


    /**
     * Função para buscar os pokemons pela API
     */
    function searchPokemon() {
        let str = $('#poke-search').val();
        load(true);
        $.ajax({
            url: '<?=Url::to(['api/get-pokemons'])?>',
            data: {name: str},
            type: 'get',
            dataType: 'json'
        }).done(function (data) {

            if (data.pokemons.length) {
                let opts = '';
                $('#poke-available').html('');
                data.pokemons.forEach(function (el) {
                    opts += '<option value="' + el.id + '">' + el.name + "</option>\n";
                });

                $('#poke-available').html(opts);
                $('#btn-add').removeClass('disabled');
            } else {
                $('#poke-available').html('<option value="">Nenhum resultado encontrado</option>');
                $('#btn-add').addClass('disabled');
            }
            load(false);

        }).fail(function (data) {
            alertDanger.alert(data.error);
        }).always(function () {
            load(false);
        })

    }


    /**
     * Função para adicionar um pokémon ao time
     */
    function pokeAdd() {

        if (POKEMONS.length >= POKE_LIMIT) {
            alertDanger.alert("Não é possível adicionar mais Pokémons. Já checkou no limite de " + POKE_LIMIT);
            return;
        }

        let $itens = $('#poke-available').val();

        if (!$itens.length) {
            alertDanger.alert('Selecione ao menos um Pokémon');
            return;
        }

        if (($itens.length + POKEMONS.length) > POKE_LIMIT) {
            alertDanger.alert('Por favor, selecione apenas ' + (POKEMONS.length ? 'mais ' + (POKE_LIMIT - POKEMONS.length) : POKE_LIMIT) + ' para compor o Time.');
            return;
        }

        //atrbuindo à variavel POKEMONS o(s) pokemons selecionado(s), DESDE que não foram atribuídos ainda.
        $('#poke-available option:selected').each(function () {
            let $this = $(this);
            if ($this.length && POKEMONS.filter(e => e.id == $this.val()).length == 0) {
                POKEMONS.push({id: $this.val(), name: $this.text()});
            }
        });

        reloadPokes();

    }

    /**
     * Recarrega o select com os pokemons selecionados
     */
    function reloadPokes() {

        let $selec = $('#poke-selected');
        if (!POKEMONS.length) {
            $selec.html('<option value="">Nenhum Pokémon selecionado</option>');
            $('#poke-selected-val').text('0');
            $('#btn-remove').addClass('disabled');
            return;
        }

        let opts = '';
        $selec.html('');
        POKEMONS.forEach(function (el) {
            opts += '<option value="' + el.id + '">' + el.name + "</option>\n";
        });

        $selec.html(opts);
        $('#poke-selected-val').text(POKEMONS.length);
        $('#btn-remove').removeClass('disabled');

        $("#poke-available option:selected").prop("selected", false);
        $("#poke-selected option:selected").prop("selected", false);

    }

    /**
     * Função para remover um pokémon selecionado
     */
    function pokeRemove() {
        let $selec = $('#poke-selected');
        if (!$selec.val()) {
            return;
        }

        //removendo o pokemon selecionado do select, através do filter
        POKEMONS = POKEMONS.filter(e => e.id != $selec.val());
        reloadPokes();

    }

    /**
     * Função para salvar os pokemons no time
     */
    function saveTeam() {

        //fazendo as validações
        if (!validateAll()) {
            return;
        }

        krajeeDialog.confirm("Confirma a criação do Time?", function (result) {
            if (result) {

                //removendo o parametro "name" do objeto, pois não é necessário
                let pokes = [];
                POKEMONS.forEach(function (el) {
                    pokes.push(el.id);
                });

                $.post({
                    url: '<?=Url::to(['api/save-team'])?>',
                    dataType: 'json',
                    data: {name: $('#team-name').val(), pokemons: pokes}
                }, function (data) {
                    if (data.hasOwnProperty('message')) {
                        alertSuccess.alert(data.message);
                        POKEMONS = [];
                        reloadPokes();
                        $('#team-name').val('')
                    }
                }).fail(function (dt) {
                    let data = dt.responseJSON;
                    if (data.hasOwnProperty('error')) {
                        alertDanger.alert(data.error);
                    } else {
                        alertDanger.alert('Houve um erro ao cadastrar o Time.');
                    }

                });
            }
        });

    }


    /**
     * Faz as validações no formulário
     */
    function validateAll() {

        if (!POKEMONS.length) {
            alertDanger.alert('Por favor, selecione ao menos 1 Pokémon');
            return false;
        }
        if (POKEMONS.length > POKE_LIMIT) {
            alertDanger.alert('Por favor, selecione somente ' + POKE_LIMIT + ' Pokémons');
            return false;
        }

        let teamname = $('#team-name').val();

        if (!teamname) {
        }

        if (teamname.length < TEAM_LIMIT) {
            alertDanger.alert('Informe o nome do Time com ao menos ' + TEAM_LIMIT + ' caracteres.');
            return false;
        }

        return true;

    }

</script>