<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('jtg-manila:init-contact-types', function () {
    \App\ContactType::firstOrCreate([
        'name' => 'General'
    ]);

    \App\ContactType::firstOrCreate([
        'name' => 'Prayer Request'
    ]);

    \App\ContactType::firstOrCreate([
        'name' => 'Giving'
    ]);
});