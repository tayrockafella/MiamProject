<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registration()
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);
        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
