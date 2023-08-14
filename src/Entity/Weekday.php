<?php
namespace App\Entity;

enum Weekday: string
{
    case Monday = "Lundi";
    case Tuesday = "Mardi";
    case Wednesday = "Mercredi";
    case Thursday = "Jeudi";
    case Friday = "Vendredi";
    case Saturday = "Samedi";
    case Sunday = "Dimanche";

    public static function getAsArray(): array {
        return array_reduce(
            self::cases(),
            static fn (array $choices, Weekday $day) => $choices + [$day->name => $day->value],
            [],
        );
    }
}