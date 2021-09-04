<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Car;
use App\Entity\Zamowienie;
use App\Entity\User;
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
     * @Route("/zamowiono/{id}", name="zamowiono")
     */
    public function zamowienie(Car $car, User $user , Zamowienie $zamowienie){
        //instantiate car / user / zamowienie
        $zamowienie = new Zamowienie();
        $car = new Car();
        $user = new User();
         // you can fetch the EntityManager via $this->getDoctrine()
         $entityManager = $this->getDoctrine()->getManager();
        //pass data using functions name fromEntity->Zamowienie.php 
        $zamowienie->setManufacturer("Polonez");
        $zamowienie->setPrice($car->getPrice());
        $zamowienie->setNumerID($car->getId());
        $zamowienie->setUsername($user->getUserIdentifier());
        $zamowienie->setStatus('reserverd');

        //insert record to zamowienie DB Table
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($zamowienie);
        $entityManager->flush();
        //redirect to list of cars,after clicking Order(button)
        return $this->redirectToRoute('car.showall');
        //show flash message
        $this->addFlash('confirmation', $zamowienie->getNumerID() . 'Your order has been placed');
    }
}
