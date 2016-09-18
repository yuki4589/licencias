<?php

use Carbon\Carbon;
use CityBoard\Entities\Activity;
use CityBoard\Entities\Archive;
use CityBoard\Entities\License;
use CityBoard\Entities\LicenseCurrentStage;
use CityBoard\Entities\LicenseStage;
use CityBoard\Entities\LicenseType;
use CityBoard\Entities\Objection;
use CityBoard\Entities\ObjectionNotification;
use CityBoard\Entities\Person;
use CityBoard\Entities\PersonPosition;
use CityBoard\Entities\TimeLimit;
use CityBoard\Entities\Titular;
use CityBoard\Entities\File;
use CityBoard\Entities\UserType;
use CityBoard\Repositories\ObjectionNotificationRepository;
use CityBoard\Repositories\ObjectionRepository;
use CityBoard\Repositories\TimeLimitRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ObjectionNotificationTest extends TestCase
{

    use DatabaseTransactions;

    private $activity;
    private $archive;
    private $licenseType;
    private $titular;
    private $license;
    private $licenseStage;
    private $firstPersonPosition;
    private $secondPersonPosition;
    private $file;
    private $person;
    private $objection;
    private $licenseCurrentStage;
    private $firstTimeLimit;
    private $secondTimeLimit;
    private $thirdTimeLimit;
    private $userType;

    private function initialize()
    {
        $this->activity = factory(Activity::class)->create();
        $this->archive = factory(Archive::class)->create();
        $this->licenseType = factory(LicenseType::class)->create();
        $this->titular = factory(Titular::class)->create();
        $this->license = factory(License::class)->create();

        $this->licenseStage = factory(LicenseStage::class)->create(['objection' => true]);
        $this->firstPersonPosition = factory(PersonPosition::class)->create();
        $this->secondPersonPosition = factory(PersonPosition::class)->create();
        $this->file = factory(File::class)->create();
        $this->userType = factory(UserType::class)->create();
        $this->person = factory(Person::class)->create();
        $this->licenseCurrentStage = factory(LicenseCurrentStage::class)->create(['weight' => 1]);
        $this->objection = factory(Objection::class)->create();

        $this->firstTimeLimit = factory(TimeLimit::class)->create([
          'days' => 10,
          'weight' => 300
        ]);
        $this->secondTimeLimit = factory(TimeLimit::class)->create([
          'days' => 20,
          'weight' => 600
        ]);
        $this->thirdTimeLimit = factory(TimeLimit::class)->create([
          'days' => 15,
          'weight' => 900
        ]);
    }

    /** @test */
    public function numberOfNotications_return_number_of_objection_notification()
    {
        $this->initialize();

        // Given
        $objectionNotificationRepository = new ObjectionNotificationRepository();
        $timeLimitRepository = new TimeLimitRepository();

        $timeLimit = $timeLimitRepository->next();
        $days = $timeLimit->days;
        $firstObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $timeLimitRepository->next($firstObjectionNotification->timeLimit->weight);
        $days += $timeLimit->days;
        $secondObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $timeLimitRepository->next($secondObjectionNotification->timeLimit->weight);
        $days += $timeLimit->days;
        $thirdObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);
        // When
        $numberOfNotifications = $objectionNotificationRepository->numberOfNotifications($this->objection->id);

        // Then
        $this->assertEquals(3, $numberOfNotifications);
    }

    /** @test */
    public function listOfTimeLimitIds_return_ids_of_time_limits()
    {
        $this->initialize();

        // Given
        $objectionNotificationRepository = new ObjectionNotificationRepository();
        $timeLimitRepository = new TimeLimitRepository();

        $timeLimit = $timeLimitRepository->next();
        $days = $timeLimit->days;
        $firstObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $timeLimitRepository->next($firstObjectionNotification->timeLimit->weight);
        $days += $timeLimit->days;
        $secondObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $timeLimitRepository->next($secondObjectionNotification->timeLimit->weight);
        $days += $timeLimit->days;
        $thirdObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        // When
        $ids = $objectionNotificationRepository->listOfTimeLimitIds($this->objection->id);

        $expectIds = [
            $firstObjectionNotification->time_limit_id,
            $secondObjectionNotification->time_limit_id,
            $thirdObjectionNotification->time_limit_id,
        ];

        $totalDays = $timeLimitRepository->totalDays($ids);
        // Then
        $this->assertEquals($expectIds, $ids);
        $this->assertEquals(45, $totalDays);
    }

    /** @test */
    public function nextTimeLimit_for_objection_return_first_if_not_notifications()
    {
        $this->initialize();

        // Given
        $objectionRepository = new ObjectionRepository();
        $objectionNotificationRepository = new ObjectionNotificationRepository();
        $timeLimitRepository = new TimeLimitRepository();

        $timeLimit = $objectionRepository->nextTimeLimit($this->objection);

        $this->assertEquals($this->firstTimeLimit->id, $timeLimit->id);

    }

    /** @test */
    public function nextTimeLimit_for_objection_return_second_if_one_notification()
    {
        $this->initialize();

        // Given
        $objectionRepository = new ObjectionRepository();
        $objectionNotificationRepository = new ObjectionNotificationRepository();
        $timeLimitRepository = new TimeLimitRepository();

        $timeLimit = $timeLimitRepository->next();
        $days = $timeLimit->days;
        $firstObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $objectionRepository->nextTimeLimit($this->objection);

        $this->assertEquals($this->secondTimeLimit->id, $timeLimit->id);
    }

    /** @test */
    public function nextTimeLimit_for_objection_return_null_if_is_the_last()
    {
        $this->initialize();

        // Given
        $objectionRepository = new ObjectionRepository();
        $objectionNotificationRepository = new ObjectionNotificationRepository();
        $timeLimitRepository = new TimeLimitRepository();

        $timeLimit = $timeLimitRepository->next();
        $days = $timeLimit->days;
        $firstObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $timeLimitRepository->next($firstObjectionNotification->timeLimit->weight);
        $days += $timeLimit->days;
        $secondObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $timeLimitRepository->next($secondObjectionNotification->timeLimit->weight);
        $days += $timeLimit->days;
        $thirdObjectionNotification = factory(ObjectionNotification::class)->create([
          'objection_id' => $this->objection->id,
          'time_limit_id' => $timeLimit->id,
          'notification_date' => Carbon::now(),
          'finish_date' => Carbon::now()->addDays($days),
        ]);

        $timeLimit = $objectionRepository->nextTimeLimit($this->objection);

        $this->assertEquals(null, $timeLimit);
    }
}