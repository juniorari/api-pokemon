<?php

use yii\helpers\Url;

class PokemonsCest
{
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/pokemons'));
    }

    public function pokemonsPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('verificando busca na página');
        $I->see('Pokémons', 'h1');


        $method = $I->grabAttributeFrom('#w0', 'method');
        $I->assertEquals('get', $method);

    }

    public function pokemonFormCanBeSubmitted(AcceptanceTester $I)
    {
        $I->amGoingTo('executando busca na página');

        $I->fillField('#pokemonsearch-name', 'arbok');
        $I->click('search-pokemon');
        
        $I->wait(2); // wait for button to be clicked

        $I->seeElement('table.table-striped tbody > tr > td:nth(1)');
        $I->see('poison');
    }
}
