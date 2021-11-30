<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="product_category")
     */
    public function category($slug, CategoryRepository $categoryRepository): Response
    {

        $category = $categoryRepository->findOneBy([
            "slug" => $slug
        ]);

        // dd($category);
        // todo: create page 404 page not found
        // we can use shortcut that privide AbstractControler
        if (!$category) {
            // throw new NotFoundHttpException("La catégorie demandée n'extiste pas");
            throw  $this->createNotFoundException("La catégorie demandée n'extiste pas");
        }
        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category' => $category
        ]);
    }

    /**
     *  @Route("/{category_slug}/{slug}", name="product_show")
     */
    public function show($slug, ProductRepository $productRepository)
    {

        // dd($urlGenerator->generate("product_category", [
        //     "slug" => "test-de-slug"
        // ]));

        $product = $productRepository->findOneBy([
            "slug" => $slug
        ]);

        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'extiste pas");
        }

        return $this->render("product/show.html.twig", [
            "product" => $product

        ]);
    }

    /**
     * @Route("/admin/product/{id}/edit", name="product_edit")
     */
    public function edit($id, ProductRepository $productRepository, Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator)
    {
        $product = $productRepository->find($id);

        $form = $this->createForm(ProductType::class, $product);

        // $form->setData($product); same thing we pase $product as argument to createForm() method
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // $product = $form->getData();  we passe $product as argument we can comment this lign
            $em->flush();
            // dd($product);
            $response = new Response;
            // $url = $urlGenerator->generate("product_show", [
            //     "category_slug" => $product->getCategory()->getSlug(),
            //     "slug" => $product->getSlug()
            // ]);
            // header('Loaction': $url) same thing buy oop version

            // $response->headers->set("Location", $url);
            // $response->setStatusCode(302);

            // shortcut version of redurection
            // $response = new RedirectResponse($url);
            // return $response;

            // return $this->redirect($url);
            return $this->redirectToRoute("product_show", [
                "category_slug" => $product->getCategory()->getSlug(),
                "slug" => $product->getSlug()
            ]);
        }

        $formView = $form->createView();


        return $this->render("product/edit.html.twig", [
            "product" => $product,
            "formView" => $formView
        ]);
    }

    /**
     * @Route("/admin/product/create", name="product_create")
     */
    public function create(FormFactoryInterface $factory,  CategoryRepository $categoryRepository, Request $request, SluggerInterface $slugger, EntityManagerInterface $em)
    {

        // $builder = $factory->createBuilder(ProductType::class);

        // $form = $builder->getForm();

        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // $product = $form->getData();
            $product->setSlug(strtolower($slugger->slug($product->getName())));
            $em->persist($product);
            $em->flush();
            // dd($product);

            return $this->redirectToRoute(
                'product_show',
                [
                    "category_slug" => $product->getCategory()->getSlug(),
                    "slug" => $product->getSlug()
                ]
            );
        }
        $formView = $form->createView();
        // dump($product);
        return $this->render("product/create.html.twig", [
            "formView" => $formView
        ]);
    }
}
