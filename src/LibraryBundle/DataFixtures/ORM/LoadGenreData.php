<?php
namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LibraryBundle\Entity\Genre;

class LoadGenreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = [
            'Fiction',
            'Comedy',
            'Drama',
            'Horror',
            'Non-fiction',
            'Realistic fiction',
            'Romance novel',
            'Satire',
            'Tragedy',
            'Tragicomedy',
            'Fantasy',
            'Mythology'
        ];

        foreach ($names as $i => $name) {
            $genre = new Genre();

            $genre->setName($name);

            $this->addReference('genre-' . $i, $genre);

            $manager->persist($genre);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}