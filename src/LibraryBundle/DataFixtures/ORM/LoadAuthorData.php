<?php
namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LibraryBundle\Entity\Author;
use Faker\Factory;

class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $author = new Author();

            $author->setFirstName($faker->firstName);
            $author->setLastName($faker->lastName);
            $author->setInfo($faker->text(500));

            $this->addReference('author-' . $i, $author);

            $manager->persist($author);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}