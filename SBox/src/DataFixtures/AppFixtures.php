<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Groups;
use App\Entity\Message;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setUsername('user' . $i);
            $user->setPassword('123456');
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setPhoto('image' . rand(1, 3) . '.jpg');
            $user->setMessages("kkkkkkkk");
            $manager->persist($user);


            for ($j = 1; $j <= 20; $j++) {
                $groups = new Groups;
                $groups->setNom('Groupe N° ' . $j);
                $groups->setUsers('user' . rand(1, 10));
                $groups->setPhoto('image' . rand(1, 3) . '.jpg');
                $groups->setUsersP("1");
                $groups->setDate(new \DateTime('now'));
                $groups->setMessages("mmmm");
                $manager->persist($groups);

                for ($x = 1; $x <= rand(1, 10); $x++) {
                    $message = new Message;
                    $message->setContent('Message N°' . $x);
                    $message->setState(rand(0, 3));
                    $message->setDateTime(new \DateTime('now'));
                    $message->setMessageGroup("yes");
                    $message->setUser('user' . rand(1, 10));
                    $manager->persist($message);
                }
            }
            $manager->flush();
        }
    }
}
