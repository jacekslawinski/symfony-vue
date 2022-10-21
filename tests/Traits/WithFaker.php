<?php

namespace Tests\Traits;

use Faker\Factory;
use Faker\Generator;

trait WithFaker
{
    /**
     *
     * @var Generator $faker
     */
    protected $faker;

    /**
     *
     * @return void
     */
    protected function setUpFaker(): void
    {
        $this->faker = Factory::create('pl');
    }
}
