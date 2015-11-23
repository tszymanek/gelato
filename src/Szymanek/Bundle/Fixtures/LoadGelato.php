<?php

namespace Szymanek\Bundle\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Szymanek\Bundle\Entity\Gelato;

class LoadGelato implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cookies = new Gelato();
        $cookies->setName('Cookies Original');
        $cookies->setDescription('Smak domowego kruchego ciasteczka z pysznym kremem czekoladowym, pełnym chrupiących ciasteczkowych okruszków.');
        $cookies->setImage('cookies_original.jpg');

        $strawberry = new Gelato();
        $strawberry->setName('Truskawowe');
        $strawberry->setDescription('Gatunki truskawek uprawianych w Polsce są uznawane za wyjątkowo dobre, nic więc dziwnego, że truskawka jest trzecim, po śmietance i czekoladzie, smakiem lodów w polskich lodziarniach.');
        $strawberry->setImage('fragola.jpg');

        $manager->persist($cookies);
        $manager->persist($strawberry);
        $manager->flush();
    }
}