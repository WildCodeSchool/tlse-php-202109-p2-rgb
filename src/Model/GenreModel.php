<?php

namespace App\Model;

class GenreModel
{
    public function getAll(): array
    {

        $cards = [
            [
                'title' => "action",
                'picture' => ""
            ],
            [
                'title' => "aventure",
                'picture' => ""
            ],
            [
                'title' => "Beat's Them All",
                'picture' => ""
            ],
            [
                'title' => "Game Jam",
                'picture' => ""
            ],
            [
                'title' => "Simulation",
                'picture' => ""
            ],
            [
                'title' => "Sport et Course",
                'picture' => ""
            ],
            [
                'title' => "Stratégie",
                'picture' => ""
            ],
            [
                'title' => "RPG",
                'picture' => ""
            ]
        ];
        return $cards;
    }

    public function getTrendingGamePicture(): string
    {
        $picture = 'https://jolstatic.fr/www/captures/5420/0/148720.jpg';
        return $picture;
    }
}
