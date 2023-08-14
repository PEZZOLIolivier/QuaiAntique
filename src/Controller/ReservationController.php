<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Entity\OpeningHours;
use App\Repository\UserRepository;
use Brick\DateTime\LocalDateTime;
use Brick\DateTime\Parser\DateTimeParseException;
use Brick\DateTime\TimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Brick\DateTime\LocalTime;


class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request, PersistenceManagerRegistry $doctrine, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $reservation = new Reservation();
        $reservation->setCreatedAt(new \DateTimeImmutable('now'));
        if ($user != null) {
            $reservation->setLastName($user->getLastName());
            $reservation->setNbPlaces($user->getdefaultNbPlaces());
            $reservation->setAllergy($user->getdefaultAllergy());
        }
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($reservation);
            $em->flush();
            $this->addFlash("success", "Voici le numéro de votre réservation: " . $reservation->getId());
        }

        return $this->render('reservation/index.html.twig', [
            'reservationForm' => $form->createView(),
            'lastName' => $user,
        ]);
    }

    #[Route('/a/reservation_slots', name: 'ajax_get_reservation_slots', methods: ['POST'])]
    public function getReservationSlots(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $datenow = LocalDateTime::now(TimeZone::utc());
        $date60d = $datenow->plusDays(60);
        try {
          $booking = LocalDateTime::parse(json_decode($request->getContent(), true)["bookingDate"]);
        } catch (DateTimeParseException $e) {
            $res = array("slots"=>"-");
            return new Response(
                json_encode($res),
                200,
                ["Content-Type" => "application/json;charset=UTF-8"]
            );
        }
//        $booking = LocalDateTime::parse(json_decode($request->getContent(), true)["bookingDate"]);

        $ohRepo = $doctrine->getManager()->getRepository(OpeningHours::class);
        $openHours = $ohRepo->findAll();
        $oh = array_filter($openHours, function ($val) use ($booking) {
            return $val->getDay()->name === $booking->getDayOfWeek()->__toString();
        });
        $oh = reset($oh);


        if ($booking < $datenow) {
            $maxPlaces = 0;

        } elseif ($booking > $date60d) {
            $maxPlaces = 0;

        } elseif ($oh->isdayclosed()) {
            $res = array("slots" => strval( 'Le restaurant est fermé le '. $oh->getDay()->value));
            return new Response(
                json_encode($res),
                200,
                ["Content-Type" => "application/json;charset=UTF-8"]
            );
        } elseif ($oh->isLunchClosed()) {
            $evening_start = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getEveningStart()));
            $evening_end = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getEveningEnd()));
            if ($booking->isAfterOrEqualTo($evening_start) && $booking->isBefore($evening_end->minusMinutes(60))) {
                $maxPlaces = $oh->getEveningMaxPlaces();
            } else {
                $res = array("slots" => strval( 'Merci de réserver pendant les horraires d\'ouverture'));
                return new Response(
                    json_encode($res),
                    200,
                    ["Content-Type" => "application/json;charset=UTF-8"]
                );
            }

        } elseif ($oh->isEveningClosed()) {
            $lunch_start = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getLunchStart()));
            $lunch_end = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getLunchEnd()));
            if ($booking->isAfterOrEqualTo($lunch_start) && $booking->isBefore($lunch_end->minusMinutes(60))) {
                $maxPlaces = $oh->getLunchMaxPlaces();
            } else {
                $res = array("slots" => strval( 'Merci de réserver pendant les horraires d\'ouverture'));
                return new Response(
                    json_encode($res),
                    200,
                    ["Content-Type" => "application/json;charset=UTF-8"]
                );
            }

        } else {
            $evening_start = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getEveningStart()));
            $evening_end = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getEveningEnd()));
            $lunch_start = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getLunchStart()));
            $lunch_end = new LocalDateTime($booking->getDate(), LocalTime::fromNativeDateTime($oh->getLunchEnd()));

            if ($booking->isAfterOrEqualTo($lunch_start) && $booking->isBefore($lunch_end->minusMinutes(60))) {
                $maxPlaces = $oh->getLunchMaxPlaces();
            } elseif ($booking->isAfterOrEqualTo($evening_start) && $booking->isBefore($evening_end->minusMinutes(60))) {
                $maxPlaces = $oh->getEveningMaxPlaces();
            } else {
                $res = array("slots" => strval( 'Merci de réserver pendant les horraires d\'ouverture'));
                return new Response(
                    json_encode($res),
                    200,
                    ["Content-Type" => "application/json;charset=UTF-8"]
                );
            }
        }

        $reservRepo = $doctrine->getManager()->getRepository(Reservation::class);
        $reservations = $reservRepo->getByDateAndService($booking->toNativeDateTime(), $oh);
        $rSlots = 0;
        foreach ($reservations as $r) {
            $rSlots += $r->getNbPlaces();
        }

        $slots = $maxPlaces - $rSlots;

        if (($maxPlaces - $rSlots) < 0) {
            $slots = 0;
        }

        $res = array("slots" => strval($slots), "maxPlaces" => strval($maxPlaces), "rSlots" => $rSlots);

        return new Response(
            json_encode($res),
            200,
            ["Content-Type" => "application/json;charset=UTF-8"]
        );
    }
}