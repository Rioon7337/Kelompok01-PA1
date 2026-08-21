<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate setting the language to EN
$request = Illuminate\Http\Request::create('/lang/en', 'GET');
$request->setSession($app->make('session')->driver());
$request->getSession()->start();
$response = $kernel->handle($request);
$kernel->terminate($request, $response);
$request->getSession()->save();

echo "After /lang/en:\n";
echo "Session locale: " . $request->getSession()->get('locale') . "\n";

// Simulate a subsequent request
$request2 = Illuminate\Http\Request::create('/', 'GET');
$request2->setSession($request->getSession());
$response2 = $kernel->handle($request2);
echo "After /:\n";
echo "App locale: " . app()->getLocale() . "\n";
