<?php

namespace App\Form;
use App\Entity\Idea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BucketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", null, [
                "label" => "Title"
            ])
            ->add("description", null, [
                "label" => "Description"
            ])
            ->add("author", null, [
                "label" => "Author"
            ])
            ->add("Category", null,[
                "label" => "Category",
                "choice_label"=> "name"

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
        ]);
    }
}
