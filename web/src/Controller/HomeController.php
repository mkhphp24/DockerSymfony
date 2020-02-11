<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Customer;
class HomeController extends AbstractController
{


    /**
     * @Route("/home", name="home")
     */
    public function index()
    {

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findByIdField(1);


        if (!$customer) {
            throw $this->createNotFoundException(
                'error get data '
            );
        }
    var_dump($customer);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
