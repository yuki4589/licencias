<?php

use CityBoard\Entities\TimeLimit;
use CityBoard\Repositories\TimeLimitRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimeLimitTest extends TestCase
{

    use DatabaseTransactions;

    private $firstTimeLimit;
    private $secondTimeLimit;
    private $lastTimeLimit;

    private function initialize() {
        $this->firstTimeLimit = factory(TimeLimit::class)->create([
          'days' => 10,
          'weight' => 300
        ]);
        $this->secondTimeLimit = factory(TimeLimit::class)->create([
          'days' => 20,
          'weight' => 600
        ]);
        $this->lastTimeLimit = factory(TimeLimit::class)->create([
          'days' => 15,
          'weight' => 900
        ]);
    }

    /** @test */
    public function next_return_next_time_limit()
    {
        $this->initialize();
        // Given
        $timeLimitRepository = new TimeLimitRepository();

        // When
        $actualNextTimeLimit = $timeLimitRepository->next($this->firstTimeLimit->weight);

        // Then
        $this->assertEquals($this->secondTimeLimit->id, $actualNextTimeLimit->id);
    }

    /** @test */
    public function next_return_first_time_limit_if_weight_null()
    {
        $this->initialize();

        // Given
        $timeLimitRepository = new TimeLimitRepository();

        // When
        $actualNextTimeLimit = $timeLimitRepository->next();

        // Then
        $this->assertEquals($this->firstTimeLimit->id, $actualNextTimeLimit->id);
    }

    /** @test */
    public function next_return_null_if_weight_is_the_maximun()
    {
        $this->initialize();

        // Given
        $timeLimitRepository = new TimeLimitRepository();

        // When
        $actualNextTimeLimit = $timeLimitRepository->next($this->lastTimeLimit->weight);

        // Then
        $this->assertEquals(null, $actualNextTimeLimit);
    }

    /** @test */
    public function totalDays_return_days_from_a_list_of_ids()
    {
        $this->initialize();

        // Given
        $timeLimitRepository = new TimeLimitRepository();

        $timeLimitIds = [
          $this->firstTimeLimit->id,
          $this->lastTimeLimit->id
        ];

        // When
        $totalDays = $timeLimitRepository->totalDays($timeLimitIds);

        // Then
        $this->assertEquals(25, $totalDays);
    }
}