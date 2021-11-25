<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
  // protected $twig;

  // public function __construct(Environment $twig)
  // {
  //   $this->twig = $twig;
  // }
  // /**
  //  * @Route("/", name="index")
  //  */
  // public function index()
  // {
  //   dd("ça function");
  // }

  /**
   * @Route("/hello/{prenom?World}", name="hello")
   */
  public function hello($prenom): Response
  {
    // dd("Hello World");
    // $html = "<html><head></head><body><h1>Hello {$prenom}</h1></body></html>";

    return $this->render(
      "hello.html.twig",
      ["prenom" => $prenom]
    );
  }

  /**
   * @Route("/exemple/{age?0}", name="exemple")
   */
  public function exemple($age): Response
  {
    return $this->render("exemple.html.twig", [
      "age" => $age
    ]);
  }
}
