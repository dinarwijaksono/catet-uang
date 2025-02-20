<?php

namespace Tests\Feature\Repository;

use App\Models\Period;
use App\Models\User;
use App\RepositoryInterface\PeriodRepositoryInterface;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeriodRepositoryTest extends TestCase
{
    protected $user;
    protected $periodRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->periodRepository = $this->app->make(PeriodRepositoryInterface::class);

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
    }

    public function test_create_success(): void
    {
        $month = 11;
        $year = 2000;

        $response = $this->periodRepository->create($this->user->id, $month, $year);

        $date = mktime(0, 0, 0, $month, 1, $year);

        $this->assertInstanceOf(Period::class, $response);
        $this->assertDatabaseHas('periods', [
            'user_id' => $this->user->id,
            'period_date' => $date,
            'period_name' => date("F Y", $date)
        ]);
    }
}
