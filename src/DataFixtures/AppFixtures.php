<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private  $slugger;
    private $passwordEncoder;

    public function  __construct(SluggerInterface $slugger, UserPasswordEncoderInterface  $passwordEncoder){
        $this->slugger = $slugger;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
$faker = Factory::create("fr_FR");



        //_________________________Création des USERS____________________________________________________________

        $user = new User();
        $user->setEmail('test@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);


for($i = 0; $i <20; $i++){
    $product = new Product();
    $product->setImg($faker->randomElement([
        'fixtures/souris1.jpg',
        'fixtures/souris2.jpg',
        'fixtures/souris3.jpg',
        'fixtures/souris4.jpg',
        'fixtures/souris5.jpg',
    ])
    );
    $product->setName($faker->name);
    $product->setSlug($this->slugger->slug($product->getName())->lower());
    $product->setDescription($faker->text(3000));
    $product->setCreatedate(new \DateTime());
    $product->setPrice($faker->numberBetween(99, 4000));
    $product->setFavori($faker->boolean());
    $color = $faker->randomElement(['rouge', 'bleu', 'blanc','noir','vert']);
    $product->setColor($color);

    $manager->persist($product);
}

        $manager->flush();
    }
}
