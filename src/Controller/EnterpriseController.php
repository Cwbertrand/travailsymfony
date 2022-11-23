<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnterpriseController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/enterprise', name: 'enterprise')]
    public function index(): Response
    {
        $entreprise = $this->em->getRepository(Enterprise::class)->findBy([], ['raisonsociale' => 'ASC']);
        return $this->render('enterprise/index.html.twig', [
            'entreprises' => $entreprise,
        ]);

    }

    //Add into entreprise and edit
    #[Route('/enterprise/add', name: 'add_enterprise')]
    #[Route('/enterprise/{id}/edit', name: 'edit_enterprise')]
    public function add(Enterprise $entreprise = null, Request $request)
    {

        //this is to edit the input entreprise
        if(!$entreprise){
            $entreprise = new Enterprise();
        }

        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entreprise = $form->getData();
            $this->em->persist($entreprise);
            $this->em->flush();

            return $this->redirectToRoute('enterprise');
        }
        
        return $this->render('enterprise/addentreprise.html.twig', [
            'form' => $form->createView(),
            'edit' => $entreprise->getId(),
        ]);

    }

    //delete enterprise
    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(Enterprise $entreprise){
        $this->em->remove($entreprise);
        $this->em->flush();

        return $this->redirectToRoute('enterprise');
    }

    //SHOW COMPANY DETAILS
    #[Route('/enterprise/{id}', name: 'show_enterprise')]
    public function show(Enterprise $entreprise): Response
    {
        
        return $this->render('enterprise/showenterprise.html.twig', [
            'detailentreprise' => $entreprise,
        ]);

    }
}
