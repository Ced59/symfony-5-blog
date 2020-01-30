<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // Créer 5 catégories fakes

        for ($i = 1; $i <= 15; $i++) {
            $category = new Category();
            $category->setTitle($faker->realText(15, 2))
                ->setDescription($faker->realText(300, 2));

            $manager->persist($category);

            // Créer enter 4 et 15 articles
            for ($j = 1; $j <= mt_rand(4, 150); $j++) {
                $article = new Article();


                $content = $faker->realText(1000, 2);


                $article->setTitle($faker->realText(30, 1))
                    ->setContent($content)
                    ->setImage('http://placeimg.com/300/150/animals/grayscale')
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(4, 100); $k++) {
                    $content = $faker->realText(300, 2);

                    $comment = new Comment();

                    $now = new \DateTime();
                    $interval = $now->diff($article->getCreatedAt());
                    $days = $interval->days;
                    $minimum = '-' . $days . ' days'; // -100 days

                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setArticle($article);

                    $manager->persist($comment);

                }
            }

        }

        $manager->flush();
    }


}
