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
    public function index(ZamowienieRepository $zamowienieRepository): Response
    {
        $zamowienie = $zamowienieRepository->findAll();
        // var_dump($zamowienie);

        return $this->render('zamowienie/index.html.twig', [
            'zamowienie' =>  $zamowienie,
        ]);
    }
   
     /**
     * @Route("/zamawiac/{id}", name="zamawiac")
     */
    public function zamawiac(Car $car): Response
    { 
        //check whether user is authenticated or not and insert into DB,who ordered a car
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
     /**
     * @Route("/update/{id}/{status}", name="update")
     */
    public function update_status(int $id, string $status)
    {   
        //call entity manager->connect to DB
        $entityManager = $this->getDoctrine()->getManager();
        //search for record in DB Table based on given ID from table with zamowienie status
        // find product and change status by given from table(dropdown table status)
        $product = $entityManager->getRepository(Zamowienie::class)->find($id);
        $product->setStatus($status);
        $entityManager->flush();

        return $this->redirectToRoute('zamowienie');
    }
      /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(int $id){
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Zamowienie::class)->find($id);
        //remove element/product from DB Table
        $entityManager->remove($product);
        $entityManager->flush();
        // redirect
        return $this->redirectToRoute('zamowienie');
    }
}
