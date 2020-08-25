<?php

use yii\helpers\Url;

class HomeCest
{
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));        
        $I->see('API Pokemon');
        $I->see('Bem vindo a Api Pokémon');

        $I->seeLink('Times');
        $I->click('Times');
        $I->wait(2); // wait for page to be opened
        
        $I->see('Times criados');
    }
}
