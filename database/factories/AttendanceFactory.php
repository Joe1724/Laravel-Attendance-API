<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User; // User model
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition()
{
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'attendance_date' => $this->faker->date(),
        'status' => $this->faker->randomElement(['present', 'absent', 'late', 'on_leave']),
    ];
}

}
