<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

  // /**
  //  * @Route("/", name="homepage")
  //  */
  // public function homepage(ProductRepository $productRepository)
  // {
  // counte([])  qui prendra un tableau de critère
  // find(id)
  // findBy([],[])  qui prendre des critère de recherches et des critère d'ordonancement et qui nous envera un tableau
  // findOnBy([])  ne prend qu'un seul paramètre : les critères de recherche 
  // findAll() qui nous renvera tout les produits

  // $product =  $productRepository->find(2);
  //   dump($product);

  /**
   * @Route("/", name="homepage")
   */
  public function homepage(ProductRepository $productRepository)
  {
    $products = $productRepository->findBy([], [], 3);




    return $this->render("home.html.twig", [
      "products" => $products
    ]);
  }
}
