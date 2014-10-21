<?php
namespace Codeception\Module;

use Laracasts\TestDummy\Factory as TestDummy;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

    public function singIn()
    {
        $username = 'demotest';
        $password = 'demodemo';

        $this->haveAnAccount(compact('username', 'password'));

        $I = $this->getModule('Laravel4');

        $I->amOnPage('/login');
        $I->fillField('username', $username);
        $I->fillField('password', $password);
        $I->click('Sing In');
    }

    public function singOut()
    {
        $I = $this->getModule('Laravel4');

        $I->amOnPage('/');
        $I->click('Logout');
    }

    public function haveAnAccount($overrides = [])
    {
        TestDummy::create('User', $overrides);
    }

}
