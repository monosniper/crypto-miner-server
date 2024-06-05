<?php

namespace App\Services;

use App\Jobs\SendQuiz;

class QuizService
{
    public function store(array $data): bool
    {
        SendQuiz::dispatch([
            'Сколько готовы инвестировать' => $data['questions']['invest'],
            'Сколько готовы уделять времени' => $data['questions']['time'],
            'Опыт инвестиций' => $data['questions']['experience'],
            'Краткосрочно/Долгосрочно' => $data['questions']['short_long'],
            'Имя' => $data['name'],
            'Номер' => $data['phone'],
            'Почта' => $data['email'],
        ]);

        return true;
    }
}
