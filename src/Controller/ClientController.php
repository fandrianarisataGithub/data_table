<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManager;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/admin/select", name = "select")
     */
     public function selectAllData(Request $request, ClientRepository $repoClient, NormalizerInterface $normalizer)
    {
        $response = new Response();
        if($request->isXmlHttpRequest()){
            $clients = $repoClient->findAll();
            $clientsNormalized = $normalizer->normalize($clients);
            $tab = array(["1", "anarana", "22-12-2019", "22-12-2019"],
                ["1", "anarana", "22-12-2019", "22-12-2019"],
                ["1", "anarana", "22-12-2019", "22-12-2019"]);
            $t = [];
            foreach ($clients as $item) {
                array_push($t, [$item->getId(),$item->getNom(), $item->getDateArrivee()->format('d-m-Y'), $item->getDateDepart()->format('d-m-Y'), '<div class="text-center"><a href="#" data-id = "'. $item->getId() . '" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></a><a href="#" data-id = "' . $item->getId() . '" class="btn btn_delete btn-danger btn-xs"><span class="fa fa-trash-o"></span></a></div>']);
            }
            $data = json_encode($t); // formater le résultat de la requête en json
           //dd($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);

            return $response;
           
            
        }
        
        $clients = $repoClient->findAll();
        
        $clientsNormalized = $normalizer->normalize($clients);
        $data = json_encode($clientsNormalized);
        // $tab =
        // array(
        //     ["1", "anarana", "22-12-2019", "22-12-2019"],
        //     ["1", "anarana", "22-12-2019", "22-12-2019"],
        //     ["1", "anarana", "22-12-2019", "22-12-2019"]
        // );
        // dd($data);
        $t = [];
        foreach ($clients as $item) {
            array_push($t, [$item->getId(), $item->getNom(), $item->getDateArrivee()->format('d-m-Y'), $item->getDateDepart()->format('d-m-Y'), '<div class="text-center"><a href="#" class="btn btn-primary btn_edit btn-xs"><span class="fa fa-edit"></span></a><a href="#" class="btn btn-danger btn-xs"><span class="fa fa-trash-o"></span></a></div>']);
        }
        //dd($t); nitestena anazy ftsn
        return $this->render('page/index.html.twig');
       
    }
  
    /**
     * @Route("/addClient", name = "addClient")
     */
    public function addClient(Request $request, ClientRepository $repoClient, EntityManagerInterface $manager)
    {   
        $response = new Response();
        $reponse = 0;
        if($request->isXmlHttpRequest()){

            $nom = $request->get('nom_client');
            $date_depart = date_create($request->get('date_depart'));
            $date_arrivee = date_create($request->get('date_arrivee'));
            if(!empty($nom) && !empty($date_depart) && !empty($date_arrivee)){
                
                $client = new Client();
                $client->setNom($nom);
                $client->setDateArrivee($date_arrivee);
                $client->setDateDepart($date_depart);
                $manager->persist($client);
                $manager->flush();
                $html = "ok";
                $reponse = $html;
                
            }
            $data = json_encode($reponse);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);
            return $response;
        }
        return $this->render('page/index.html.twig');
    }
    /**
     * @Route("/admin/delete_client/{id}", name = "delete_client")
     */
    public function delete_client($id, EntityManagerInterface $manager, ClientRepository $repoClient, Request $request)
    {
        $response = new Response();
        if($request->isXmlHttpRequest()){
            $client = $repoClient->find($id);
            $manager->remove($client);
            $manager->flush();
            $data = json_encode("suppression ok");
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);
            return $response;
        }
    }

    /**
     * @Route("/admin/edit_client", name = "edit_client")
     */
    public function edit_client($id, EntityManagerInterface $manager, ClientRepository $repoClient, Request $request)
    {
        $response = new Response();
        if ($request->isXmlHttpRequest()) {
            $client = $repoClient->find($id);
            $manager->remove($client);
            $manager->flush();
            $data = json_encode("suppression ok");
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);
            return $response;
        }
    }



}
