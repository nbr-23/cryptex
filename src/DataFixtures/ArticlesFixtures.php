<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Faker;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

    
        for($j = 1; $j <= 3; $j++){

            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph(2));
            $manager->persist($category);

            // creer entre 4 et 6 articles
            for($i = 1; $i <= mt_rand(4, 6); $i++){
                $article = new Article();

                
                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
             

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);

                $manager->persist($article);

                // On donne des commentaires à l'article
                for($k = 1; $k <= mt_rand(4, 10); $k++ ){

                    $comment = new Comment();

                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                   
                    $days = (new \DateTime())->diff($article->getCreatedAt())->days;
                  

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween( '-' . $days . 'days'))
                            ->setArticle($article);

                    $manager->persist($comment);

                }
        }
            

        }

        $manager->flush();
    }
}
