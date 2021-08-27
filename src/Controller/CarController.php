<?php

namespace App\Controller;

use App\Entity\Car;
//use App\Form\Type\CarType;
use App\Form\CarType;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car", name="car.")
 */

class CarController extends AbstractController
{
    //dostepny pod url /car/showall
    /**
     * @Route("/", name="showall")
     */
    public function index(CarRepository $carRepository): Response
    {
        $page_title = "Cars List";
        $repository = $this->getDoctrine()->getRepository(Car::class);
        $cars = $repository->findAll();

        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
            'cars' => $cars,
            'page_title' => $page_title,
        ]);
    }
    //dostepny pod url /car/create
    /**
     * @Route("/create", name="create_car")
     */
    public function create(Request $request):Response
    {   
        //fetch EntityManager via $this->getDoctrine();
        $entityManager = $this->getDoctrine()->getManager();
        //instantiate Car Object from App\Entity\Car
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        //process form and submitted data by user
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$form->getData() holds submitted data
            $car = $form->getData();
            // get submitted image
            $image = $request->files->get('image')['image'];
            //if image is submitted->save it in folder web application
            if($image){

            }
            //tell doctrine you want to eventaully save object
            $entityManager->persist($car);
            //save $car to DB Table
            $entityManager->flush();

            return $this->redirectToRoute('car.showall');
        }
        // return new Response('Saved Car into DB with ID: ' . $car->getId());
        return $this->render('car/create.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete_car")
     *
     */
    public function delete(int $id):Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $car = $entityManager->getRepository(Car::class)->find($id);

        $entityManager->remove($car);
        $entityManager->flush();

        //add flash message for confirmation
        $this->addFlash(
            'notice',
            'Requested record was deleted with ID number: ' . $id
        );

        return $this->redirectToRoute('car.showall', [
            'id' => $car->getId()
        ]);
    }
}
