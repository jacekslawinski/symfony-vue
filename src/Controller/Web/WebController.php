<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class WebController extends AbstractController
{
    #[Route('/{subject}', requirements: ['subject' => 'user|hardware|system'])]
    public function mainPath(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/')]
    public function home(): Response
    {
        return $this->render('base.html.twig');
    }
}
