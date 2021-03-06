<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("name", TextType::class, [
                "label" => "Nom de produit",
                "attr" => [
                    // "class" => "form-control", 
                    "placeholder" => "Tapez le nom du produit"
                ]
            ])
            ->add("shortDescription", TextareaType::class, [
                "label" => "Description courte",
                "attr" => [
                    // "class" => "form-control",
                    "placeholder" => "Tapez un description courte mais parente pour le visiteur"
                ]
            ])
            ->add("price", MoneyType::class, [
                "label" => "Prix du produit",
                "attr" => [
                    // "class" => "form-control",
                    "placeholder" => "Tapez le prix du produit en euros"
                ]
            ])
            ->add("mainPicture", UrlType::class, [
                "label" => "Image du produit",
                "attr" => ["placeholder" => "Tapez une URL d'mage !"]
            ])

            ->add("category", EntityType::class, [
                "label" => "Catégorie",
                "attr" => ["class" => "form-control"],
                "placeholder" => "-- Choisir une catégore --",
                "class" => Category::class,
                // "choice_label" => "name"
                // create an anonymous function and capitalize content
                "choice_label" => function (Category $category) {
                    return strtoupper($category->getName());
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
