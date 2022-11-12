<?php
session_start();
require_once('app.class.php');
$app    = new xPay;
if (isset($_SESSION['user']) && isset($_SESSION['uuid'])) {
    $userId     = $_SESSION['user'];
    $uuid       = $_SESSION['uuid'];

    $user       = $app->getUser(['uuid' => $uuid]);
    if ($user != "404") {
        $firstName  = $user->first_name;
        $lastName   = $user->last_name;
        $phone      = $user->phone;
        $email      = $user->email;
        $currency   = $user->currency;
        $country    = $user->country;

        $wallets    = $app->getWallets(['user' => $userId]);
        if ($wallets == "404") {
            // $app->createWallet($userId, $uuid, $accountNumber, $bank $currency, $externalRef);
            // header("Location: ./create-wallet.php");
        }
    } else {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}