<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const CATEGORIES = [
        ['nom' => 'Photographie de spectacle', 'slug' => 'photographie-spectacle', 'position' => 1],
        ['nom' => "Photographie d'evenement", 'slug' => 'photographie-evenement', 'position' => 2],
        ['nom' => 'Photographie associative', 'slug' => 'photographie-associative', 'position' => 3],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $data) {
            $categorie = new Categorie();
            $categorie->setNom($data['nom']);
            $categorie->setSlug($data['slug']);
            $categorie->setPosition($data['position']);

            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
