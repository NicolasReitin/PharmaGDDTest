<?php 

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Form\MarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;

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


    /**
     * @Route("/admin/marques/new", name="admin_marque_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($marque);
            $entityManager->flush();

            return $this->redirectToRoute('admin_marque_index');
        }

        return $this->render('@SyliusAdmin/Marque/Grid/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/marques/edit/{id}", name="admin_marque_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('admin_marque_index');
        }

        return $this->render('@SyliusAdmin/Marque/Grid/edit.html.twig', [
            'form' => $form->createView(),
            'marque' => $marque,
        ]);
    }

    /**
     * @Route("/admin/marques/delete/{id}", name="admin_marque_delete", methods={"POST"})
     */
    public function delete(Request $request, Marque $marque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->request->get('_token'))) {
            $entityManager->remove($marque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_marque_index');
    }

}
