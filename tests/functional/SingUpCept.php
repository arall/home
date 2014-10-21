<?php

$I = new FunctionalTester($scenario);
$I->am('Guest');
$I->wantTo('Sing up for an account');

$I->amOnPage('/');
$I->click('Register');
$I->seeCurrentUrlEquals('/register');

$I->fillField('Username', 				'JohnDoe');
$I->fillField('Email', 					'john@example.com');
$I->fillField('Password', 				'demodemo');
$I->fillField('Password Confirmation', 	'demodemo');
$I->click('Sing Up');

$I->seeCurrentUrlEquals('');
$I->see('Thanks for signing up!');

$I->seeRecord('users', [
    'username' 	=> 'JohnDoe',
    'email' 	=> 'john@example.com',
]);

$I->assertTrue(Auth::check());
