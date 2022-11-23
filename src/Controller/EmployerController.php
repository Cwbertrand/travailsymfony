<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Enterprise;
use App\Form\EmployerType;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployerController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/employer', name: 'employer')]
    public function index(): Response
    {
        $employer = $this->em->getRepository(Employe::class)->findBy([], ['nom' => 'ASC']);
        return $this->render('employer/index.html.twig', [
            'employers' => $employer,
        ]);
    }

    //Add into database
    #[Route('/employer/add', name: 'add_employer')]
    //this is to edit the specific id of the employer
    #[Route('/employer/{id}/edit', name: 'edit_employer')]
    public function add(Employe $employer = null, Request $request)
    {
        //if employer doesn't exist, create a new object employer, but if it already exits, edit existing info
        if(!$employer){
            $employer = new Employe();
        }
        
        $form = $this->createForm(EmployerType::class, $employer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employer = $form->getData();
            $this->em->persist($employer);
            $this->em->flush();

            return $this->redirectToRoute('employer');
        }
        
        return $this->render('employer/addemployer.html.twig', [
            'form' => $form->createView(),
            'edit' => $employer->getId(),
        ]);

    }

    //delete employer
    #[Route('/employer/{id}/delete', name: 'delete_employer')]
    public function delete(Employe $employer){
        $this->em->remove($employer);
        $this->em->flush();

        return $this->redirectToRoute('employer');
    }

    //SHOW EMPLOYER DETAILS
    #[Route('/employer/{id}', name: 'show_employer')]
    public function show(Employe $employers): Response
    {
        
        return $this->render('employer/showemployer.html.twig', [
            'detailemployer' => $employers,
        ]);
    }
}
