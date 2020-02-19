<?php

return [

    'register' => [
        'subject' => 'Hi [first], welcome to rolpta',
        'body'    => '
    <p>Hi [first], welcome to rolpta</p>
    <p>Your activation token is [code]</p>
    <p></p>
    <p>rolpta Team</p>
    '],

    'password' => [
        'subject' => 'Hi [first], recover your password on rolpta',
        'body'    => '
    <p>Hi [first], thank you for using rolpta</p>
    <p>Your password reset token is [code]</p>
    <p></p>
    <p>rolpta team</p>
    '],

    'activate' => [
        'subject' => 'Hi [first], activate account on rolpta',
        'body'    => '
    <p>Thanks [first] for signing up on rolpta</p>
    <p>Your activation token is [code]</p>
    <p></p>
    <p>rolpta team</p>
    '],

    'verifymail' => [
        'subject' => 'Hi [first], change your email address on rolpta',
        'body'    => '
    <p>Hi [first], thank you for using rolpta</p>
    <p>Your email change token is [code]</p>
    <p></p>
    <p>rolpta team</p>
    '],

];
