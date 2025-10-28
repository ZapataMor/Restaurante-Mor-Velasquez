<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        Feedback::create([
            'client_name' => 'María Torres',
            'type' => 'valoración',
            'comment' => 'Excelente atención y comida deliciosa.',
            'rating' => 5,
        ]);

        Feedback::create([
            'client_name' => 'Pedro López',
            'type' => 'queja',
            'comment' => 'La sopa estaba un poco fría.',
            'rating' => 3,
        ]);
    }
}
