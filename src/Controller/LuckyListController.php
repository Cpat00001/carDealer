<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyListController extends AbstractController
{
    /**
     * @Route("/lucky/list", name="lucky_list")
     */
    public function luckyShow(CarRepository $carRepository): Response
    {
        // query for all cars in DB
        $repository = $this->getDoctrine()->getRepository(Car::class);
        $cars = $repository->findAll();

        //choose only 2 random from DB use php array_rand()
        $random_cars = array_rand($cars, 2);
            $random_one = $cars[$random_cars[0]];
            $random_two = $cars[$random_cars[1]]; 

        return $this->render('lucky_list/index.html.twig', [
            'page_name' => 'Lucky List of Products',
            'cars' => $cars,
            'random_one' => $random_one,
            'random_two' => $random_two
        ]);
    }
}
