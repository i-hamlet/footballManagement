<?php

namespace App\DataFixtures;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const FOOTBALL_TEAMS = [
        "Manchester United",
        "Real Madrid",
        "Barcelona",
        "Bayern Munich",
        "Liverpool",
        "Juventus",
        "Paris Saint-Germain",
        "Manchester City",
        "Chelsea",
        "Arsenal",
        "Tottenham Hotspur",
        "Atletico Madrid",
        "Borussia Dortmund",
        "Inter Milan",
        "AC Milan",
        "Ajax",
        "Roma",
        "Napoli",
        "Benfica",
        "Porto",
        "Sporting CP",
        "Marseille",
        "Lyon",
        "Monaco",
        "Bayer Leverkusen",
        "Schalke 04",
        "Sevilla",
        "Valencia",
        "Real Betis",
        "Villarreal",
        "Leicester City",
        "Everton",
        "West Ham United",
        "Wolverhampton Wanderers",
        "Leeds United",
        "Newcastle United",
        "Aston Villa",
        "Crystal Palace",
        "Southampton",
        "Brighton & Hove Albion",
        "Burnley",
        "Fulham",
        "Norwich City",
        "Brentford",
        "Hoffenheim",
        "Hertha BSC",
        "Borussia Mönchengladbach",
        "Stuttgart",
        "Eintracht Frankfurt",
        "Werder Bremen",
        "Freiburg"
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $teams = [];
        for ($i = 0; $i < 50; $i++) {
            $teams[] = (new Team())->setName(self::FOOTBALL_TEAMS[$i])
                ->setCountry($faker->unique()->country)
                ->setBalance(300000000.00);
        }

        $generatedNames = [];
        foreach ($teams as $team) {
            for ($i = 0; $i < 10; $i++) {
                $faker = Factory::create();
                $firstName = $faker->unique()->firstName;
                $lastName = $faker->unique()->lastName;

                //Check for duplicate names
                while (in_array("$firstName $lastName", $generatedNames)) {
                    $firstName = $faker->unique()->firstName;
                    $lastName = $faker->unique()->lastName;
                }

                $generatedNames[] = "$firstName $lastName";

                $player = new Player();
                $player->setFirstName($firstName);
                $player->setLastName($lastName);
                $player->setTeam($team);
                $manager->persist($team);
                $manager->persist($player);
            }
        }

        $manager->flush();



//            $generatedNames = [];
//            for ($i = 0; $i < 10; $i++) {
//                $firstName = $faker->unique()->firstName;
//                $lastName = $faker->unique()->lastName;

//              Check for duplicate names
//                while (in_array("$firstName $lastName", $generatedNames)) {
//                    $firstName = $faker->unique()->firstName;
//                    $lastName = $faker->unique()->lastName;
//                }
//
//                $generatedNames[] = "$firstName $lastName";
//
//                $player = new Player();
//                $player->setFirstName($firstName);
//                $player->setLastName($lastName);
//                $player->setTeam($team);
//
//                $manager->persist($player);
//            }
//        }

        $manager->flush();
    }
}
