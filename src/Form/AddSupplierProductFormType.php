<?php

namespace App\Form;

use App\Entity\SupplierProduct;
use App\Entity\SupplierProductRoot;
use App\Entity\SupplierProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddSupplierProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('root', EntityType::class, [
                'label' => 'Корневая система',
                'required' => true,
                'class' => SupplierProductRoot::class,
                'choice_label' => 'name',
                'placeholder' => 'Не выбрано',
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('containerSize', TextType::class, [
                'label' => 'Размер контейнера',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group d-none'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('type', EntityType::class, [
                'label' => 'Тип',
                'required' => true,
                'class' => SupplierProductType::class,
                'choice_label' => 'name',
                'placeholder' => 'Не выбрано',
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('height', TextType::class, [
                'label' => 'Высота',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', TelType::class, [
                'label' => 'Цена',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('countMin', TextType::class, [
                'label' => 'Мин. кол-во',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('countMax', TextType::class, [
                'label' => 'Макс. кол-во',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('diameterBarrel', TextType::class, [
                'label' => 'Диаметр ствола',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('diameterCrown', TextType::class, [
                'label' => 'Диаметр кроны',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('diameterComa', TextType::class, [
                'label' => 'Диаметр земляного кома',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Примечание',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 7
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SupplierProduct::class,
        ]);
    }
}
