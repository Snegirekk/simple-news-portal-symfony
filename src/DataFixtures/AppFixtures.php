<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Entity\Category;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $articleContent = <<<EOT
Lorem ipsum dolor sit amet, te his volutpat definiebas, ius ea idque impedit. At eam officiis ponderum. Choro accusata deterruisset eam at, est ea alii latine. Integre forensibus inciderint eos eu, dico erat magna et eum.
At quo choro alienum indoctum. Insolens menandri posidonium nec te. Ea nam copiosae accusata hendrerit, novum latine adipisci est no. Eu nec timeam disputationi, eam esse dicunt te, autem quodsi ea has. Te sed ipsum decore, sapientem scriptorem id sea, quo sint incorrupte accommodare in.
Ut ius quodsi perfecto concludaturque, no ridens facilisi dissentias mel. Vel ea perfecto perpetua adolescens, ad vim tantas oportere. Per ne modus gubergren consequat. Latine volumus invidunt vim id, eum etiam vocent graecis ei, ea summo congue deterruisset est. Mei cu brute deserunt. Rebum postulant corrumpit pri ne, vitae corpora ponderum ex cum, mazim vitae cu duo.
EOT;
        $comments = [
            'Lorem ipsum dolor sit amet, te his volutpat definiebas, ius ea idque impedit.',
            'At eam officiis ponderum.',
            'Choro accusata deterruisset eam at, est ea alii latine.',
            'At quo choro alienum indoctum.',
            'Insolens menandri posidonium nec te.',
            'Ea nam copiosae accusata hendrerit, novum latine adipisci est no.',
            'Ut ius quodsi perfecto concludaturque, no ridens facilisi dissentias mel. Vel ea perfecto perpetua adolescens, ad vim tantas oportere.',
        ];

        $categories = [];

        for ($i = 1; $i < 4; ++$i) {
            $category = new Category();
            $category->setName('Category #' . $i);

            $categories[] = $category;
            $manager->persist($category);
        }

        $subCategory = new Category();
        $subCategory
            ->setName('SubCategory')
            ->setParent($categories[rand(0, 2)]);
        $categories[] = $subCategory;
        $manager->persist($subCategory);

        $articles = [];

        for ($i = 8; $i > 0; --$i) {
            $article = new Article();
            $article
                ->setTitle('News Article #' . $i)
                ->setSlug('news-article-' . $i)
                ->setAnnouncement('Lorem ipsum dolor sit amet, te his volutpat definiebas, ius ea idque impedit. At eam officiis ponderum. Choro accusata deterruisset eam at, est ea alii latine.')
                ->setContent($articleContent)
                ->setCategory($categories[rand(0, 3)])
                ->setIsActive(true)
                ->setCreatedAt(new DateTime($i * 2 . ' hours ago'));

            $articles[] = $article;
            $manager->persist($article);
        }

        for ($i = 0; $i < 20; ++$i) {
            $comment = new ArticleComment();
            $comment
                ->setContent($comments[rand(0, 6)])
                ->setArticle($articles[rand(0, 6)]);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
