<?php

namespace App\Controller;

// pour gérer les articles
use App\Entity\Thearticle;
// pour gérer les sections
use App\Entity\Thesection;
// pour utiliser Doctrine
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    // ?
    protected array $menu;
    public function __construct(EntityManagerInterface $entityManager){
       $this->menu = $entityManager->getRepository(Thesection::class)->selectAllSection();
    }
    // ?
    #[Route('/', name: 'app_public')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // on récupère toutes les sections
        $sections = $this->menu;
        // 3 derniers articles
        $threeArticles = $entityManager->getRepository(Thearticle::class)->findBy(['thearticleactivate'=>1],['thearticledate'=>'DESC'],3);
        return $this->render('public/index.html.twig', [
            'articles' => $threeArticles,
            'sections' => $sections,
        ]);
    }

    #[Route('/blog', name: 'app_public_blog')]
    public function blog(EntityManagerInterface $entityManager): Response
    {

        // On récupère tous les articles
        $threeArticles = $entityManager->getRepository(Thearticle::class)->findBy(['thearticleactivate'=>1],['thearticledate'=>'DESC']);

        return $this->render('public/blog.html.twig', [
            'articles' => $threeArticles,
            'sections' => $this->menu,
        ]);
    }

    #[Route('/article/{slug}', name: 'app_public_detail_article')]
    public function detailArticle(string $slug, EntityManagerInterface $entityManager): Response
    {


        // on récupère le détail de l'article via son slug
        $article = $entityManager->getRepository(Thearticle::class)->findOneBy(['thearticleslug'=>$slug]);


        return $this->render('public/detail.article.html.twig',[
            'article' => $article,
            'sections' => $this->menu,
        ]);

    }
}
