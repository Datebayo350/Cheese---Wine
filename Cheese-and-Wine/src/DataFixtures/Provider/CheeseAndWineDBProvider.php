<?php 

namespace App\DataFixtures\Provider;


// Fake datas for tests
class CheeseAndWineDBProvider extends \Faker\Provider\Base
{
    // 15 Cheeses
    private static $cheeses = [
        'Roquefort',
        'Crottin de Chavignol',
        'Brie de Meaux',
        'Camembert',
        'Brillât Savarin',
        'Tôme des Pyrénées',
        'Saint-Félicien',
        'Raclette',
        'Le Trou du Cru',
        'Petit Billy',
        'Pont-l\'évêque',
        'Reblochon',
        'Beaufort',
        'Mimolette',
        'Comté'
    ];

    // 15 wines
    private static $wines = [
        'Château Le Comte',
        'Château Cantemerle',
        'Château La Lagune',
        'Pétrus',
        'Château d\'Yquem',
        'Château Angélus',
        'Château Mouton Rothschild',
        'Château Latour',
        'Château Bellegrave',
        'Petit Billy',
        'Domaine Louis Jadot',
        'Domaine Leflaive',
        'Louis Roederer',
        'Domaine Servin',
        'Château Beychevelle'
    ];

    // 15 origins
    private static $origins = [
        'Bordeaux',
        'Aveyron',
        'Savoie',
        'Ain',
        'Sauterne',
        'Ile Et Vilaine',
        'Seine Et Marne',
        'Savoie',
        'Nord',
        'Champagne',
        'Bourgogne',
        'Medoc',
        'Côte d\'or',
        'Pyrénées',
        'Astuces de Sioux'
    ];

    /**
     * Get a random cheese
     */
    public function cheeseName()
    {
        return $this->generator->randomElement(self::$cheeses);
    }

    /**
     * Get a random wine
     */
    public function wineName()
    {
        return $this->generator->randomElement(self::$wines);
    }

    /**
     * Get a random wine
     */
    public function originsName()
    {
        return $this->generator->randomElement(self::$origins);
    }
  
}