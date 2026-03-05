<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
Route::get('/time-test', function () {
    return [
        'php' => date('Y-m-d H:i:s'),
        'laravel' => now()->toDateTimeString(),
    ];
});
