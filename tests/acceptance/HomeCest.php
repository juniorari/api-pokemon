<?php

class HomeCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function exibindoPaginaHome(AcceptanceTester $I)
    {
        $I->amOnPage('/site/index');
        $I->see('API Pokemon');
        $I->see('Bem vindo a Api Pokémon');

        $I->amGoingTo('open Times page');
        $I->seeLink('Times');
        $I->click('Times');
        $this->wait(1); // wait for page to be opened

        $I->see('Times criados');
    }

    public function wait($sec = 1) {
        sleep($sec);
    }
}
