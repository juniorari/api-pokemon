<?php

use yii\helpers\Url;

class CreateTeamCest
{
    public function ensureCreateTimeWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/criar-times'));
        $I->see('Forme seu Time de Pokémons');

        $I->amGoingTo('check create team ok');

        $this->create($I);

        $I->expectTo('see message create successfully');
        $I->see('Time "TEAM TEST" cadastrado com Sucesso!');
        $I->wait(1);
        $I->click('.bootstrap-dialog-footer-buttons > button:nth-child(1)');

        $I->wait(2);
        $I->expectTo('see message error created team');

        $this->create($I);
        $I->wait(2);
        $I->see('Já existe um time com o nome informado. Verifique!');

    }

    function create(AcceptanceTester $I) {
        $I->click('#poke-available');
        $I->click('#btn-add');
        $I->wait(1); // wait for button to be clicked

        $I->fillField('input#team-name]', 'Team Test');
        $I->click('#btn-save');
        $I->wait(2); // wait show dialog

        $I->click('div.bootstrap-dialog-footer-buttons button.btn.btn-warning');
        $I->wait(3); // wait show dialog
    }
}
