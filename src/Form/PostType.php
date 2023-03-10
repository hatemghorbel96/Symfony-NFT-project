<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Collect;
use App\Entity\Category;
use App\Repository\CollectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user= $options['user'];
        $builder
            ->add('img',FileType::class, [
                'attr'=>['class'=>'file-drop-input'],
                'label'=> '',
                'data_class' => null,
                'required' => true])
        
            ->add('title',TextType::class,[
                'attr'=> [
                    'class'=>'form-control'
                ]
                ])
            ->add('description',TextareaType::class,[
                'attr'=> [
                    'rows'=>5,
                    'class'=>'form-control'
                ]
                
            ])
            ->add('price',IntegerType::class,[
                'required'=>false,
                'by_reference' => true,
              'attr'=>[
                'class'=>'form-control',
                'placeholder'=>'Enter price'
              ]
            ])
            ->add('currency',ChoiceType::class,[
                'required'=>false,
                    'by_reference' => true,
                'choices'=>
                [
                    'ETH'=>'ETH'
                ],
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('currencyv',ChoiceType::class,[
                'required'=>false,
                    'by_reference' => true,
                'choices'=>
                [
                    'ETH'=>'ETH'
                ],
                'attr'=>[
                    'class'=>'form-control',
                ]
            ])
            ->add('minbet',IntegerType::class,[
                'required'=>false,
                'by_reference' => true,
                'attr'=>[
                    'class'=>'form-control'
                    
                ]
            ])
            ->add('datedeb',DateTimeType::class,[
                'widget'=>'single_text',
                'required'=>false,
                    'by_reference' => true,
                'attr'=>[
                    'class'=>'form-control date-picker rounded pe-5',
                    'placeholder'=>'Choose date start'
                ]
            ])
            ->add('datefin',DateTimeType::class,[
                'required'=>false,
                    'by_reference' => true,
                'widget'=>'single_text',
               
                'attr'=>[
                    'class'=>'form-control date-picker rounded pe-5',
                    'placeholder'=>'Choose date end',
                ]
            ])
            ->add('category',EntityType::class,['class' => Category::class,
            'choice_label' => 'name',
            'label' => 'category',
           
    
            'attr'=>['class' => 'form-select']]
            )
            ->add('collect',EntityType::class,['class' => Collect::class,
            'choices'=>$user->getCollects(),
            'label' => 'collect',
           
    
            'attr'=>['class' => 'form-select']]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class, 'user'=> array(),
        ]);
    }
}
