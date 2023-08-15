<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Weekday;
use App\Entity\OpeningHours;
use App\Entity\Photo;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // OPENING HOURS
        $lunchStart = new \DateTime('12:00');
        $lunchEnd = new \DateTime('14:30');
        $eveningStart = new \DateTime('19:00');
        $eveningEnd = new \DateTime('23:00');

        $monday = new OpeningHours();
        $monday->setDay(Weekday::Monday)
            ->setIsDayClosed(true)
            ->setIsLunchClosed(false)
            ->setIsEveningClosed(false);
        $manager->persist($monday);

        $tuesday = new OpeningHours();
        $tuesday->setDay(Weekday::Tuesday)
            ->setIsDayClosed(false)
            ->setIsLunchClosed(false)
            ->setLunchStart($lunchStart)
            ->setLunchEnd($lunchEnd)
            ->setLunchMaxPlaces(50)
            ->setIsEveningClosed(false)
            ->setEveningStart($eveningStart)
            ->setEveningEnd($eveningEnd)
            ->setEveningMaxPlaces(50);
        $manager->persist($tuesday);

        $wednesday = new OpeningHours();
        $wednesday->setDay(Weekday::Wednesday)
            ->setIsDayClosed(false)
            ->setIsLunchClosed(false)
            ->setLunchStart($lunchStart)
            ->setLunchEnd($lunchEnd)
            ->setLunchMaxPlaces(50)
            ->setIsEveningClosed(true);
        $manager->persist($wednesday);

        $thursday = new OpeningHours();
        $thursday->setDay(Weekday::Thursday)
            ->setIsDayClosed(false)
            ->setIsLunchClosed(false)
            ->setLunchStart($lunchStart)
            ->setLunchEnd($lunchEnd)
            ->setLunchMaxPlaces(50)
            ->setIsEveningClosed(false)
            ->setEveningStart($eveningStart)
            ->setEveningEnd($eveningEnd)
            ->setEveningMaxPlaces(50);
        $manager->persist($thursday);

        $friday = new OpeningHours();
        $friday->setDay(Weekday::Friday)
            ->setIsDayClosed(false)
            ->setIsLunchClosed(false)
            ->setLunchStart($lunchStart)
            ->setLunchEnd($lunchEnd)
            ->setLunchMaxPlaces(50)
            ->setIsEveningClosed(false)
            ->setEveningStart($eveningStart)
            ->setEveningEnd($eveningEnd)
            ->setEveningMaxPlaces(50);
        $manager->persist($friday);

        $saturday = new OpeningHours();
        $saturday->setDay(Weekday::Saturday)
            ->setIsDayClosed(false)
            ->setIsLunchClosed(false)
            ->setLunchStart($lunchStart)
            ->setLunchEnd($lunchEnd)
            ->setLunchMaxPlaces(50)
            ->setIsEveningClosed(false)
            ->setEveningStart($eveningStart)
            ->setEveningEnd($eveningEnd)
            ->setEveningMaxPlaces(50);
        $manager->persist($saturday);

        $sunday = new OpeningHours();
        $sunday->setDay(Weekday::Sunday)
            ->setIsDayClosed(false)
            ->setIsLunchClosed(true)
            ->setIsEveningClosed(false)
            ->setEveningStart($eveningStart)
            ->setEveningEnd($eveningEnd)
            ->setEveningMaxPlaces(50);
        $manager->persist($sunday);

        $manager->flush();

        // PHOTOS
        $p1 = new Photo();
        $p1->setPicture("garnitures-800x600-64d0e0737f73d629501813.webp");
        $p1->setPictureFile(new File("public/pictures/photos/garnitures-800x600-64d0e0737f73d629501813.webp"));
        $p1->setTitle("Garniture");
        $p1->setIsPublish(true);
        $manager->persist($p1);

        $p2 = new Photo();
        $p2->setPicture("liegeois800600-64da311e0466e957368518.webp");
        $p2->setPictureFile(new File("public/pictures/photos/liegeois800600-64da311e0466e957368518.webp"));
        $p2->setTitle("Café liégeois maison");
        $p2->setIsPublish(false);
        $manager->persist($p2);

        $p3 = new Photo();
        $p3->setPicture("collinbordelaise-64da2f89ed76d852056072.jpg");
        $p3->setPictureFile(new File("public/pictures/photos/collinbordelaise-64da2f89ed76d852056072.jpg"));
        $p3->setTitle("Collin à la bordelaise");
        $p3->setIsPublish(false);
        $manager->persist($p3);

        $p4 = new Photo();
        $p4->setPicture("fondue-la-savoyarde-800600-64da2fbe5ea30085246532.jpg");
        $p4->setPictureFile(new File("public/pictures/photos/fondue-la-savoyarde-800600-64da2fbe5ea30085246532.jpg"));
        $p4->setTitle("Fondue Savoyarde");
        $p4->setIsPublish(false);
        $manager->persist($p4);

        $p5 = new Photo();
        $p5->setPicture("plat-principal-800x600-64d0e099b7b1a413789882.webp");
        $p5->setPictureFile(new File("public/pictures/photos/plat-principal-800x600-64d0e099b7b1a413789882.webp"));
        $p5->setTitle("Plat principal");
        $p5->setIsPublish(true);
        $manager->persist($p5);

        $p6 = new Photo();
        $p6->setPicture("plat-unique-800x600-64d0e0b1c736f722833832.webp");
        $p6->setPictureFile(new File("public/pictures/photos/plat-unique-800x600-64d0e0b1c736f722833832.webp"));
        $p6->setTitle("Plat unique");
        $p6->setIsPublish(true);
        $manager->persist($p6);

        $p7 = new Photo();
        $p7->setPicture("76089088-800x600-64d0e0234aa11390969082.jpg");
        $p7->setPictureFile(new File("public/pictures/photos/76089088-800x600-64d0e0234aa11390969082.jpg"));
        $p7->setTitle("Plateau de légumes en salade");
        $p7->setIsPublish(true);
        $manager->persist($p7);

        $p8 = new Photo();
        $p8->setPicture("poelee-betteraves-paquerettes-oeufs-plat-800x600-64d0e0cf2157a261727228.jpg");
        $p8->setPictureFile(new File("public/pictures/photos/poelee-betteraves-paquerettes-oeufs-plat-800x600-64d0e0cf2157a261727228.jpg"));
        $p8->setTitle("Poelée Betteraves");
        $p8->setIsPublish(true);
        $manager->persist($p8);

        $p9 = new Photo();
        $p9->setPicture("porc-aigre-doux-chine-800x600-64d0dfe97361c288419500.jpg");
        $p9->setPictureFile(new File("public/pictures/photos/porc-aigre-doux-chine-800x600-64d0dfe97361c288419500.jpg"));
        $p9->setTitle("Porc aigre doux");
        $p9->setIsPublish(true);
        $manager->persist($p9);

        $p10 = new Photo();
        $p10->setPicture("risotto-carottes-parmesan-thermomix-800x600-64da2e83a8f9f569599134.webp");
        $p10->setPictureFile(new File("public/pictures/photos/risotto-carottes-parmesan-thermomix-800x600-64da2e83a8f9f569599134.webp"));
        $p10->setTitle("Risotto");
        $p10->setIsPublish(false);
        $manager->persist($p10);

        $p11 = new Photo();
        $p11->setPicture("salade-cesare-64d0e201239d6822785994.webp");
        $p11->setPictureFile(new File("public/pictures/photos/salade-cesare-64d0e201239d6822785994.webp"));
        $p11->setTitle("Salade César");
        $p11->setIsPublish(false);
        $manager->persist($p11);

        $p12 = new Photo();
        $p12->setPicture("tarte-citron-meringuee-800600-64da319c01825296111333.jpg");
        $p12->setPictureFile(new File("public/pictures/photos/tarte-citron-meringuee-800600-64da319c01825296111333.jpg"));
        $p12->setTitle("Tarte au citron");
        $p12->setIsPublish(false);
        $manager->persist($p12);

        $manager->flush();

        // CATEGORIES

        $c1 = new Category();
        $c1->setName("Entrées");
        $c1->setIsActive(true);
        $manager->persist($c1);

        $c2 = new Category();
        $c2->setName("Plats");
        $c2->setIsActive(true);
        $manager->persist($c2);

        $c3 = new Category();
        $c3->setName("Desserts");
        $c3->setIsActive(true);
        $manager->persist($c3);

        $manager->flush();

        // CARD & MENUS

        $menu1 = new Menu();
        $menu1->setName("Menus du jour")
            ->setDescription("Viande accompagnée de sa garniture")
            ->setPhoto($p1)
            ->setIsPublish(true)
            ->setPrice(17.50);
        $manager->persist($menu1);

        $menu2 = new Menu();
        $menu2->setName("Menus Savoyard (4 personnes)")
            ->setDescription(" 	Fondue Savoyarde (vin blanc et fromage de savoie)")
            ->setPhoto($p4)
            ->setIsPublish(true)
            ->setPrice(54.00);
        $manager->persist($menu2);

        $manager->flush();

        $dish1 = new Dish();
        $dish1->setCategory($c1)
            ->setName("Salade composé")
            ->setDescription(" 	Plateaux de légumes et jambons en salade)")
            ->setPhoto($p7)
            ->setIsPublish(true)
            ->setPrice(8.00);
        $manager->persist($dish1);

        $dish2 = new Dish();
        $dish2->setCategory($c1)
            ->setName("Salade César")
            ->setDescription("Salade césare maison")
            ->setPhoto($p11)
            ->setIsPublish(true)
            ->setPrice(7.50);
        $manager->persist($dish2);

        $dish3 = new Dish();
        $dish3->setCategory($c2)
            ->setName("Risotto")
            ->setDescription("Risotto campagnard aux carottes et champignons frais")
            ->setPhoto($p10)
            ->setIsPublish(true)
            ->setPrice(22.00);
        $manager->persist($dish3);

        $dish4 = new Dish();
        $dish4->setCategory($c2)
            ->setName("Colin à la bordelaise")
            ->setDescription("Filet de colin à la bordelaise accompagné de riz")
            ->setPhoto($p3)
            ->setIsPublish(true)
            ->setPrice(15.00);
        $manager->persist($dish4);

        $dish5 = new Dish();
        $dish5->setCategory($c3)
            ->setName("Café liégeois")
            ->setDescription("Café liégeois fait maison")
            ->setPhoto($p2)
            ->setIsPublish(true)
            ->setPrice(9.50);
        $manager->persist($dish5);

        $dish6 = new Dish();
        $dish6->setCategory($c3)
            ->setName("Tarte au citron")
            ->setDescription("Tarte au citron faite maison sur son lite merringué")
            ->setPhoto($p12)
            ->setIsPublish(true)
            ->setPrice(9.00);
        $manager->persist($dish6);

        $manager->flush();

        //USERS

        $user1 = new User();
        $user1->setEmail('admin@quai-antique.fr');
        $user1->setPassword($this->hasher->hashPassword($user1, '0123456789'));
        $user1->setLastName('PEZZOLI');
        $user1->setFirstName('Olivier');
        $user1->setPhoneNumber('01 02 03 04 05');
        $user1->setIsVerified(true);
        $user1->setRoles(["ROLE_ADMIN"]);
        $user1->setDefaultNbPlaces(1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('testuser@quai-antique.fr');
        $user2->setPassword($this->hasher->hashPassword($user2, '0123456789'));
        $user2->setLastName('ASTRUC');
        $user2->setFirstName('Arnaud');
        $user2->setPhoneNumber('06 40 30 04 05');
        $user2->setIsVerified(true);
        $user2->setDefaultNbPlaces(4);
        $manager->persist($user2);

        $manager->flush();
    }
}
