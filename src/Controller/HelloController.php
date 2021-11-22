<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{


  /**
   * @Route("/", name="index")
   */
  public function index()
  {
    dd("ça function");
  }

  /**
   * @Route("/hello/{name?World}", name="hello")
   */
  public function hello($name): Response
  {
    // dd("Hello World");

    return new Response("Hello $name");
  }
}
