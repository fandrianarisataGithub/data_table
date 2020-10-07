<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, ClientRepository $repoClient)
    {   
        $client = new Client();
        $clients = $repoClient->findAll();
        return $this->render('page/index.html.twig', [
            'items' => $clients,
        ]);
    }
}
