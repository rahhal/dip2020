<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	private $passwordEncoder;

	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
	    $user = new User();
	    $user->setEmail('x@gmail.com');
	    $user->setRoles(['ROLE_SUPER_ADMIN']);
	    $user->setPassword($this->passwordEncoder->encodePassword($user, '123'));

	    $user_1 = new User();
	    $user_1->setEmail('x+1@gmail.com');
	    $user_1->setRoles(['ROLE_ADMIN']);
	    $user_1->setPassword($this->passwordEncoder->encodePassword($user_1, '123'));

	    $manager->persist($user);
	    $manager->persist($user_1);
	    $manager->flush();
    }
}
