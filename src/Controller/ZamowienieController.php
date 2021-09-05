<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Car;
use App\Entity\User;
use App\Entity\Zamowienie;

use App\Repository\ZamowienieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZamowienieController extends AbstractController
{
    /**
     * @Route("/zamowienie", name="zamowienie")
     */
    public function index(): Response
    {
        return $this->render('zamowienie/index.html.twig', [
            'controller_name' => 'ZamowienieController',
        ]);
    }
   
     /**
     * @Route("/zamawiac/{id}", name="zamawiac")
     */
    public function zamawiac(Car $car): Response
    { 
        //instantiate car / user / zamowienie
        $zamowienie = new Zamowienie();
       // you can fetch the EntityManager via $this->getDoctrine()
         $entityManager = $this->getDoctrine()->getManager();
        //pass data using functions name fromEntity->Zamowienie.php 
        $zamowienie->setManufacturer($car->getName());
        // $zamowienie->setPrice($car->getPrice());
        $zamowienie->setPrice($car->getPrice());
        // $zamowienie->setNumerID($car->getId());
        $zamowienie->setNumerID($car->getId());
        // $zamowienie->setUsername($user->getUserIdentifier());
        $zamowienie->setUsername("tymczosowy");
        $zamowienie->setStatus('reserverd');

        //insert record to zamowienie DB Table
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($zamowienie);
        $entityManager->flush();
        //show flash message
        $this->addFlash('confirmation', ' Car with ID nr:  ' . $zamowienie->getNumerID() . 'has been added.');
        //redirect to list of cars,after clicking Order(button)
        return $this->redirectToRoute('lucky_list');
        
    }
}
