<?php 

class PokemonsCest
{
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage('/site/pokemons');
    }

    public function pokemonsPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('verificando busca na página');
        $I->see('Pokémons', 'h1');

    }

    public function buscandoPokemonArbok(AcceptanceTester $I)
    {
        $I->amGoingTo('executando busca na página');

        $I->fillField('#pokemonsearch-name', 'arbok');
        $I->click('search-pokemon');

        $this->wait(1);
        $I->see('poison');
    }

    public function wait($sec = 1) {
        sleep($sec);
    }
}
