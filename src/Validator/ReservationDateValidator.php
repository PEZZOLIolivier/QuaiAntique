<?php

namespace App\Validator;


use Brick\DateTime\LocalTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Brick\DateTime\LocalDateTime;
use Brick\DateTime\TimeZone;

class ReservationDateValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint): void
    {
        If (!$constraint instanceof ReservationDate) {
            throw new UnexpectedTypeException($constraint, ReservationDate::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof \DateTime) {
            throw new UnexpectedValueException($value, 'DateTime');
        }

        $datenow = LocalDateTime::now(TimeZone::utc());
        $date60d = $datenow->plusDays(60);
        $booking = LocalDateTime::fromNativeDateTime($value);
        $bookingDay = $booking->getDayOfWeek()->__toString();

        $openingHours = array_filter($constraint->openHours, function($val) use ($bookingDay) {
           return $val->getDay()->name === $bookingDay;
        });
        $openingHours = reset($openingHours);

        $time = $booking->getTime();

        $msg = '';

        if ($booking < $datenow) {
            $msg = $this->context->addViolation($constraint->messageBefore);

        } elseif ($booking > $date60d) {
            $msg = $this->context->addViolation($constraint->messageAfter);

        } elseif ($openingHours->isDayClosed()) {
            $msg = $this->context->addViolation($constraint->messageDayClosed);

        } elseif ($openingHours->isLunchClosed()) {
            $evening_start = LocalTime::fromNativeDateTime($openingHours->getEveningStart());
            $evening_end = LocalTime::fromNativeDateTime($openingHours->getEveningEnd());
            if ($time->isBefore($evening_start) || $time->isAfter($evening_end)) {
                $msg = $this->context->addViolation($constraint->messageOutsideOh);
            } elseif ($time->isAfter($evening_end->minusMinutes(60)) && $time->isBeforeOrEqualTo($evening_end)){
                $msg = $this->context->addViolation($constraint->messageLastHour);
            }

        } elseif ($openingHours->isEveningClosed()) {
            $lunch_start = LocalTime::fromNativeDateTime($openingHours->getLunchStart());
            $lunch_end = LocalTime::fromNativeDateTime($openingHours->getLunchEnd());
            if ($time->isBefore($lunch_start) || $time->isAfter($lunch_end)) {
                $msg = $this->context->addViolation($constraint->messageOutsideOh);
            } elseif ($time->isAfter($lunch_end->minusMinutes(60)) && $time->isBeforeOrEqualTo($lunch_end)){
                $msg = $this->context->addViolation($constraint->messageLastHour);
            }

        } else {
            $lunch_start = LocalTime::fromNativeDateTime($openingHours->getLunchStart());
            $lunch_end = LocalTime::fromNativeDateTime($openingHours->getLunchEnd());
            $evening_start = LocalTime::fromNativeDateTime($openingHours->getEveningStart());
            $evening_end = LocalTime::fromNativeDateTime($openingHours->getEveningEnd());
            if ($time->isBefore($lunch_start) || $time->isAfter($evening_end) || ($time->isAfter($lunch_end) && $time->isBefore($evening_start))) {
                $msg = $this->context->addViolation($constraint->messageOutsideOh);
            } elseif (($time->isAfter($lunch_end->minusMinutes(60)) && $time->isBeforeOrEqualTo($lunch_end)) || ($time->isAfter($evening_end->minusMinutes(60)) && $time->isBeforeOrEqualTo($evening_end))) {
                $msg = $this->context->addViolation($constraint->messageLastHour);
            }
        }
    }
}