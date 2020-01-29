<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // Créer 5 catégories fakes

        for ($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence)
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            // Créer enter 4 et 15 articles
            for ($j = 1; $j <= mt_rand(4, 15); $j++) {
                $article = new Article();

                $content = '<p>';
                $content .= join($faker->paragraphs(5), '</p><p>');
                $content .= '</p>';

                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(4, 50); $k++) {
                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

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