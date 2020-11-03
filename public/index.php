<?php

/*
 * Die login.php Datei ist der Einstiegspunkt des MVC. Hier werden zuerst alle
 * vom Framework benötigten Klassen geladen und danach wird die Anfrage dem
 * Dispatcher weitergegeben.
 *
 * Wie in der .htaccess Datei beschrieben, werden alle Anfragen, welche nicht
 * auf eine bestehende Datei zeigen hierhin umgeleitet.
 */

require_once __DIR__.'/../vendor/autoload.php';

use App\Dispatcher\Dispatcher;
use App\Exception\ExceptionListener;

error_reporting(E_ALL & ~E_NOTICE);

ExceptionListener::register();
Dispatcher::dispatch();
