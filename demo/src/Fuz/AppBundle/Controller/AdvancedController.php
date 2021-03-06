<?php

namespace Fuz\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Fuz\AppBundle\Base\BaseController;
use Fuz\AppBundle\Entity\ValueData;
use Fuz\AppBundle\Form\ValueType;

/**
 * @Route("/advanced")
 */
class AdvancedController extends BaseController
{

    /**
     * Advanced usage
     *
     * You can reference your form collection in the view, instead of
     * putting a selector in the form type.
     *
     * @Route("/mvcCompliance", name="mvcCompliance")
     * @Template()
     */
    public function mvcComplianceAction(Request $request)
    {
        $data = array ('values' => array ("a", "b", "c"));

        $form = $this
           ->createFormBuilder($data)
           ->add('values', 'collection',
              array (
                   'type' => 'text',
                   'label' => 'Add, move, remove values and press Submit.',
                   'options' => array (
                           'label' => 'Value',
                   ),
                   'allow_add' => true,
                   'allow_delete' => true,
                   'prototype' => true,
                   'required' => false,
//                   'attr' => array (
//                           'class' => 'my-selector', <--- Not MVC compliant!
//                   ),
           ))
           ->add('submit', 'submit')
           ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isValid())
        {
            $data = $form->getData();
        }

        return array (
                'form' => $form->createView(),
                'data' => $data,
        );
    }

    /**
     * Advanced usage
     *
     * A custom form theme helps define button's layout and positions as and where you want.
     *
     * @Route("/customFormTheme", name="customFormTheme")
     * @Template()
     */
    public function customFormThemeAction(Request $request)
    {
        $data = array('values' => array(new ValueData("a"), new ValueData("b"), new ValueData("c")));

        $form = $this
           ->createFormBuilder($data)
           ->add('values', 'collection',
              array (
                   'type' => new ValueType(),
                   'label' => 'Add, move, remove values and press Submit.',
                   'allow_add' => true,
                   'allow_delete' => true,
                   'prototype' => true,
                   'required' => false,
                   'attr' => array (
                           'class' => 'collection',
                   ),
           ))
           ->add('submit', 'submit')
           ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isValid())
        {
            $data = $form->getData();
        }

        return array (
                'form' => $form->createView(),
                'data' => $data,
        );
    }

    /**
     * Advanced usage
     *
     * Collection of collections are useful on the most dynamic forms, and a good
     * way to test if the plugin is working as expected too.
     *
     * @Route("/collectionOfCollections", name="collectionOfCollections")
     * @Template()
     */
    public function collectionOfCollectionsAction(Request $request)
    {
        $data = array (
                'collections' => array (
                        array(new ValueData("a"), new ValueData("b"), new ValueData("c")),
                        array(new ValueData("d"), new ValueData("e"), new ValueData("f")),
                        array(new ValueData("g"), new ValueData("h"), new ValueData("i")),
                ),
        );

        $form = $this
           ->get('form.factory')
           ->createNamedBuilder('form', 'form', $data)
           ->add('collections', 'collection',
              array (
                   'type' => 'collection',
                   'label' => 'Add, move, remove collections',
                   'options' => array (
                           'type' => new ValueType(),
                           'label' => 'Add, move, remove values',
                           'options' => array (
                                   'label' => 'Value',
                           ),
                           'allow_add' => true,
                           'allow_delete' => true,
                           'prototype' => true,
                           'prototype_name' => '__children_name__',
                           'attr' => array (
                                   'class' => "child-collection",
                           ),
                   ),
                   'allow_add' => true,
                   'allow_delete' => true,
                   'prototype' => true,
                   'prototype_name' => '__parent_name__',
                   'attr' => array (
                           'class' => "parent-collection",
                   ),
           ))
           ->add('submit', 'submit')
           ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isValid())
        {
            $data = $form->getData();
        }

        return array (
                'form' => $form->createView(),
                "data" => $data,
        );
    }

}
