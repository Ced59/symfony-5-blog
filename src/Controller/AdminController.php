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
    public function index(UserRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $users = $repo->findAll();

        if ($request->isMethod('post'))
        {
            $posts = $request->request->all();
            dump($posts);

            $user = $repo->find($request->request->get("idUser"));

            $roles = [];
            foreach ($posts as $key=>$post)
            {
                dump($key);
                array_push($roles, $request->request->get($key));
            }
            dump($roles);

            unset($roles[count($roles)-1]);
            dump($roles);
            $user->setRoles($roles);
            $manager->persist($user);
            $manager->flush();

        }


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

}
