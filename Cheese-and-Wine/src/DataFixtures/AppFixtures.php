<?php

namespace App\DataFixtures;


use Faker;
use App\Entity\User;
use App\Entity\Wine;
use App\Entity\Cheese;
use App\Entity\Origin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\CheeseAndWineDBProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    // Une propriété pour accueillir notre encodeur
    private $encoder;

    // On récupère notre "service" via le constructeur de la fixture
    // qui est elle-même un service
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(objectManager $manager)
        {

        // Faker object initialization
        $faker = Faker\Factory::create();

        // Get the provider
        $faker->addProvider(new CheeseAndWineDBProvider($faker));

        // Get the same datas
        $faker->seed(123);
        
        //? On veut deux utilisateurs
        
        // Super Admin
        $superAdmin = new User();
        $superAdmin->generateApiToken();
        $superAdmin->setEmail('supadmin@supadmin.com');
        $superAdmin->setName('Super Admin');
        $superAdmin->setPassword($this->encoder->encodePassword($superAdmin, 'supadmin'));
        $superAdmin->setRoles(['ROLE_SUPER_ADMIN']);
        $superAdmin->setCreatedAt($faker->dateTime());

        $manager->persist($superAdmin); 

        // Admin
        $admin = new User();
        $admin->generateApiToken();
        $admin->setEmail('admin@admin.com');
        $admin->setName('Admin');
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setCreatedAt($faker->dateTime());

        $manager->persist($admin);

        // User
        $user = new User();
    
        $user->generateApiToken();
        $user->setEmail('user@user.com');
        $user->setName('User');
        $user->setPassword($this->encoder->encodePassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt($faker->dateTime());

        $manager->persist($user);
        
        // Get 10 origins
        $originsList = [];

        for ($i = 0; $i < 10; $i++) {

            $origin = new Origin();

            $origin->setName($faker->unique()->originsName());
            $origin->setCreatedAt($faker->dateTime());

            // Store origins in Array
            $originsList[] = $origin;

            // Persist in DataBase
            $manager->persist($origin);

        } 

            
        // Get 10 wines
        $winesList = [];

        for ($i = 0; $i < 10; $i++) {

            $wine = new Wine();

            $wine->setName($faker->unique()->wineName());
            $wine->setAppellation($faker->word());
            $wine->setPicture($faker->word());
            $wine->setDescription($faker->word());
            $wine->setCreatedAt($faker->dateTime());
            $wine->setType($faker->word());
            
        // Generate random origins
        for ($origin = 0; $origin < mt_rand(1,3); $origin++) {

            // Get a random cheese in origin list on the top
            $randomOrigin = $faker->randomElement($originsList);
            $wine->setOrigin($randomOrigin);
        }
            

        // On persist
        $manager->persist($wine);
        // On stocke le genre pour usage ultérieur       
        $winesList[] = $wine;
    
        } 

        // Get 10 cheeses
        $cheesesList = [];
            
        for ($i = 0; $i < 10; $i++) {

        $cheese = new Cheese();
    
        // Get proprieties
        $cheese->setName($faker->unique()->cheeseName());
        $cheese->setMilk($faker->unique()->word());
        $cheese->setPicture('https://www.lechariotafromages.fr/671/crottin-de-chavignol-fermier.jpg');
        $cheese->setDescription($faker->word());
        $cheese->setCreatedAt($faker->dateTime());
        
        // Generate random origins
        for ($origin = 0; $origin < mt_rand(1,3); $origin++) {

            // Get a random cheese in origin list on the top
            $randomOrigin = $faker->randomElement($originsList);
            $cheese->setOrigin($randomOrigin);
        }

        // Store cheeses list in array      
        $cheesesList[] = $cheese;

        // Persist
        $manager->persist($cheese);

        }


        // On éxécute les requetes 
        $manager->flush();
    }

}