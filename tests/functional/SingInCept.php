<?php

$I = new FunctionalTester($scenario);
$I->am('Registered user');
$I->wantTo('Log In');

$I->singIn();

$I->seeCurrentUrlEquals('');
$I->see('Logout');

$I->assertTrue(Auth::check());

$I->singOut();
