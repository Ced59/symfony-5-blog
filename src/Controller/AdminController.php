<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\AdminRoleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_show")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }
}
