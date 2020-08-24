<?php

/* @var $this yii\web\View */

use app\models\Pokemon;
use yii\helpers\Url;

$this->title = "Criar Time";
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
#poke-selected-val {
    font-weight: bold;
}
");
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
                                <input type="text" onkeyup="searchPokemon()" class="form-control" id="poke-search" placeholder="Digite para iniciar a buscar...">
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
                            <button class="btn btn-success btn-block" onclick="pokeAdd()"> >> </button>
                            <button class="btn btn-danger btn-block" onclick="pokeRemove()"> << </button>
                            <br>
                        </div>
                        <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                                <select multiple="" class="form-control" id="poke-selected" size="10">
                                    <option>Nenhum Pokémon selecionado</option>
                                </select>
                                <small>Selecionados <span id="poke-selected-val">0</span> Pokémons</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-lg-5">
                            <div class="form-group">
                                <label>Qual o nome do Time?</label>
                                <input class="form-control" placeholder="Inform aqui o nome do seu time de Pokémons">
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block">Gravar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
$this->registerJs('searchPokemon();', $this::POS_READY);
?>
<script>

    // O limite de pokemons que pode ser adicionado
    let POKE_LIMIT = 6;
    // Os pokemons adicionados
    let POKEMONS = [];

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
                        
            let opts = '';
            $('#poke-available').html('');
            data.pokemons.forEach(function(el) {
                opts+= '<option value="' + el.id + '">' + el.name + "</option>\n";
            });

            $('#poke-available').html(opts);
            load(false);

        }).fail(function(data) {
            alert(data.error);
        }).always(function() {
            load(false);
        })

    }


    /**
     * Função para adicionar um pokémon ao time
     */
    function pokeAdd() {

        if (POKEMONS.length >= POKE_LIMIT) {
            alert("Não é possível adicionar mais Pokémons. Já checkou no limite de " + POKE_LIMIT);
            return;
        }

        let $itens = $('#poke-available').val();

        if (!$itens.length) {
            alert('Selecione ao menos um Pokémon');
            return;
        }

        if (($itens.length + POKEMONS.length) > POKE_LIMIT) {
            alert('Por favor, selecione apenas ' + (POKEMONS.length ? 'mais ' + (POKE_LIMIT - POKEMONS.length) : POKE_LIMIT ) + ' para compor o Time.');
            return;
        }

        //atrbuindo à variavel POKEMONS o(s) pokemons selecionado(s), DESDE que não foram atribuídos ainda.
        $('#poke-available option:selected').each(function () {
            let $this = $(this);
            if ($this.length && POKEMONS.filter(e => e.id == $this.val()).length == 0) {
                POKEMONS.push({id: $this.val(), name: $this.text()});
            }
        });

        $("#poke-available option:selected").prop("selected", false);
  
        reloadPokes();

    }

    function reloadPokes() {

        let $selec = $('#poke-selected');
        if (!POKEMONS.length) {
            $selec.html('<option>Nenhum Pokémon selecionado</option>');
            $('#poke-selected-val').text('0');
            return;
        }

        let opts = '';
        $selec.html('');
        POKEMONS.forEach(function(el) {
            opts+= '<option value="' + el.id + '">' + el.name + "</option>\n";
        });

        $selec.html(opts);        
        $('#poke-selected-val').text(POKEMONS.length);

    }


</script>