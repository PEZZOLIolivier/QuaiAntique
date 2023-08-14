<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;
use App\Entity\OpeningHours;

#[\Attribute]
class ReservationDate extends Constraint
{
    public $openHours = [];
    public $messageBefore = 'La date de réservation ne peut pas se trouver dans le passé';
    public $messageAfter = 'Vous ne pouvez pas réservez pour une date dépassant les 60 Jours';
    public $messageDayClosed = 'Le restaurant est fermé ce jour ';
    public $messageOutsideOh = 'Votre réservation est en dehors de nos horraires d\'ouverture';
    public $messageLastHour =  'Vous ne pouvez pas réserver lors de la dernière heure du service';

    #[HasNamedArguments]
    public function __construct($oh, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
        $this->openHours = $oh;
    }
}