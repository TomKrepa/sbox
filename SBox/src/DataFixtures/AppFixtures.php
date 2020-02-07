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
        for ($i = 1; $i <= 5; $i++) {
            $user = new User;
            $user->setUsername('user' . $i);
            $user->setPassword('123456');
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setPhoto('image' . rand(1, 3) . '.jpg');

            for ($j = 1; $j <= 5; $j++) {
                $groups = new Groups;
                $groups->setNom('Groupe N° ' . $j . 'du user' . $i);
                $groups->addUser($user); //Nombre des users dans le groupe 
                $groups->setPhoto('image' . rand(1, 3) . '.jpg');
                $groups->setUserAdmin($user); //L'admin du groupe
                $groups->setDate(new \DateTime('now'));                
                $user->addGroupe($groups); //liste des groupes attribués à l'utilisateur
                $manager->persist($groups);
                
            }

            for ($x = 1; $x <= rand(1, 5); $x++) {
                $message = new Message;
                $message->setContent('Message N°' . $x);
                $message->setState(rand(0, 3));
                $message->setDateTime(new \DateTime('now'));
                $message->setGroupe($groups);
                $message->setUser($user); //auteur du message
                $manager->persist($message);
                $groups->addMessage($message); //Les IDs des messages du groupe
            }


            $manager->persist($user);






            $manager->flush();
        }
    }
}
