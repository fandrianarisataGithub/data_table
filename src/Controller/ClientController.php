<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ClientController extends AbstractController
{
    /**
     * @Route("/admin/select", name = "select")
     */
    public function selectAllData(Request $request, ClientRepository $repoClient)
    {
        $response = new Response();
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();

            $RAW_QUERY = 'SELECT * FROM client ORDER BY id DESC;';

            $statement = $em->getConnection()->prepare($RAW_QUERY);
            // Set parameters 
            $statement->bindValue('status', 1);
            $statement->execute();

            $clients = $statement->fetchAll();
            $data = json_encode($clients); // formater le résultat de la requête en json
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);
            return $response;
            
        }
        // $em = $this->getDoctrine()->getManager();

        // $RAW_QUERY = 'SELECT * FROM client ORDER BY id DESC;';

        // $statement = $em->getConnection()->prepare($RAW_QUERY);
        // // Set parameters 
        // $statement->bindValue('status', 1);
        // $statement->execute();

        $clients = $repoClient->findAll();
        $tab = [];
        foreach($clients as $item){
            array_push($tab, array(
                'nom' => $item->getNom(),
                'date_arrivee' => $item->getDateArrivee(),
                'date_depart' => $item->getDateDepart(),
            ));
        }
        
        $data = json_encode($tab); // formater le résultat de la requête en json
        // dd($data);
        // $response->headers->set('Content-Type', 'application/json');
        // $response->setContent($data);

        // return $response;
        return new JsonResponse(
            array(
                'status' => 'OK',
                'message' => $tab
            ),
            200
        );
    }
}
