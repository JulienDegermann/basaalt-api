<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Stock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StocksFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $stocks = [
            'Vêtements' => [
                [
                    'name' => 'T-shirt',
                    'price' => 20,
                    'description' => 'T-shirt Basaalt',
                    'stocks' => [
                        [
                            'size' => 'XS',
                            'color' => '#000',
                            'quantity' => 20,

                        ],
                        [
                            'size' => 'S',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'M',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'L',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'XL',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'XXL',
                            'color' => '#000',
                            'quantity' => 20,
                        ]],

                ],
                [
                    'name' => 'Sweatshirt',
                    'price' => 20,
                    'description' => 'Sweatshirt Basaalt',
                    'stocks' => [
                        [
                            'size' => 'XS',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'S',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'M',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'L',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'XL',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'XXL',
                            'color' => '#000',
                            'quantity' => 20,
                        ]],

                ],

            ],
            'Musique' => [
                [
                    'name' => 'Album 1',
                    'price' => 8,
                    'description' => 'Music Basaalt',
                    'stocks' => [
                        [
                            'size' => null,
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                    ],
                ],
                [
                    'name' => 'Album 2',
                    'price' => 8,
                    'description' => 'Music Basaalt',
                    'stocks' => [
                        [
                            'size' => 'TU',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                    ],
                ],
            ],
            'Packs' => [
                [
                    'name' => 'Alnbum 1 + T-shirt',
                    'price' => 25,
                    'description' => 'T-shirt Basaalt + Album 1',
                    'stocks' => [
                        [
                            'size' => 'XS',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'S',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'M',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'L',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'XL',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                        [
                            'size' => 'XXL',
                            'color' => '#000',
                            'quantity' => 20,
                        ],
                    ],
                ],
            ],

        ];

        foreach ($stocks as $category => $articles) {
            $currentCategory = new Category();
            $currentCategory->setName($category);
            $manager->persist($currentCategory);

            foreach ($articles as $article) {
                $currentArticle = (new Article())
                    ->setName($article['name'])
                    ->setPrice($article['price'])
                    ->setDescription($article['description'])
                    ->setCategory($currentCategory);

                $manager->persist($currentArticle);

                foreach ($article['stocks'] as $stock) {
                    $currentStock = (new Stock())
                        ->setSize($stock['size'])
                        ->setColor($stock['color'])
                        ->setQuantity($stock['quantity'])
                        ->setArticle($currentArticle);

                    $manager->persist($currentStock);
                }
            }
        }
        $manager->flush();
    }
}