<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Group;
use App\Entity\Message;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        public function load(ObjectManager $manager)
        {
            for($i = 1; $i <= 10; $i++){
                $user = new User;
                $user -> setUsername('user' . $i);
                $user -> setPassword('123456');
                $user -> setEmail('user' . $i . '@gmail.com');
                $user -> setPicture('image' . rand(1,3) . '.jpg')
                $manager -> persist($user);
            }
            $manager->flush();
            for($j = 1; $j <= 20; $j++){
                $groups = new Groups;
                $groups -> setName('Groupe N° ' . $j);
                $groups -> setUsers('user' . rand(1,10));
                $groups -> setPicture('image' . rand(1,3) . '.jpg');
                $groups -> setDate(new \DateTime('now'));

                $manager -> persist($group);
                
                for($x = 1; $x <= rand(1,10); $x++){
                    $message = new Message;
                    $message -> setContent('Message N°' . $x);
                    $message -> setState(rand(0,3))
                    $message -> setRegisterDate(new \DateTime('now'));
                    $message -> setUser('user' . rand(1,10));
                    $manager -> persist($message);    		
                }
                }
                $manager->flush();
            }
        }
    }
    