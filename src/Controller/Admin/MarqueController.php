<?php 

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarqueRepository;

class MarqueController extends AbstractController
{
    /**
     * @Route("/admin/marques", name="admin_marque_index")
     */
    public function index(MarqueRepository $marqueRepository): Response
    {
        $marques = $marqueRepository->findAll();

        return $this->render('@SyliusAdmin/Marque/Grid/index.html.twig', [
            'marques' => $marques,
        ]);
    }
}
