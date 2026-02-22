<?php

namespace Tests\Feature\Service;

use App\Models\User;
use App\Service\ReportService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use stdClass;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    protected $reportService;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->reportService = $this->app->make(ReportService::class);
        $this->user = User::first();
    }

    public function test_get_total_income_spending()
    {
        $result = $this->reportService->getTotalIncomeSpending($this->user->id);

        $this->assertInstanceOf(stdClass::class, $result);
        $this->assertObjectHasProperty('total_income', $result);
        $this->assertObjectHasProperty('total_spending', $result);
        $this->assertIsInt($result->total_income);
        $this->assertIsInt($result->total_spending);
        $this->assertEquals($result->total_income, 10000);
        $this->assertEquals($result->total_spending, 30000);
    }
}
