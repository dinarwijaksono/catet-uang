<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'mysql-test']);

        DB::delete('delete from users');
        DB::delete('delete from sessions');
        DB::delete('delete from api_tokens');
        DB::delete('delete from periods');
        DB::delete('delete from categories');
        DB::delete('delete from transactions');
        DB::delete('delete from file_uploads');
    }
}
