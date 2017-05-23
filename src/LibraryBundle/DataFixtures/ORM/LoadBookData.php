<?php
namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LibraryBundle\Entity\Book;
use Faker\Factory;

class LoadBookData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Get authors
        $authors = [];
        for ($i = 0; $i < 50; $i++) {
            $authors[] = $this->getReference('author-' . $i);
        }

        // Get genres
        $genres = [];
        for ($i = 0; $i < 10; $i++) {
            $genres[] = $this->getReference('genre-' . $i);
        }

        for ($i = 0; $i < 100; $i++) {
            $book = new Book();

            $book->setIsbn($faker->unique()->isbn13);
            $book->setCover($faker->imageUrl(768, 768));
            $book->setTitle(rtrim($faker->sentence, '.'));
            $book->setAnnotation($faker->text(500));
            $book->setNumberOfPages($faker->numberBetween(10, 1000));
            $book->setStatus($faker->randomElement(['New', 'In Progress', 'Approved', 'Rejected', 'Published', 'Deleted']));
            $book->setAddedAt(new \DateTime());
            if ($book->getStatus() == 'Published') {
                $book->setPublishedAt(new \DateTime());
            }

            foreach ($faker->randomElements($authors, $faker->numberBetween(1, 3)) as $author) {
                $book->addAuthor($author);
            }

            foreach ($faker->randomElements($genres, $faker->numberBetween(1, 3)) as $genre) {
                $book->addGenre($genre);
            }

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 30;
    }
}