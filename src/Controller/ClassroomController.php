<?php

namespace App\Controller;
use App\Controller\Request;
use App\Form\ClassroomType;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/list', name: 'list_CLASSROOM')]
    public function list(): Response
    {
        $Classroom = array(
            array('id' => 1,'name' => '2A28'),
            array('id' => 2,'name' => '3B16'),
            array('id' => 3,'name' => '5A12'),
            array('id' => 4,'name' => '3A26'),
            array('id' => 5,'name' => '3P11'),
            array('id' => 6,'name' => '3A1'),
            array('id' => 7,'name' => '2A28'),
            array('id' => 8,'name' => '3B16'));
            return $this->render('classroom/Affiche.html.twig', ['classroom' => $Classroom]);
        }
    #[Route('affiche',name:'app_affiche')]
    public function Affiche (ClassroomRepository $repository)
    {
        $Classroom=$repository->findAll();
        return $this->render('Classroom/Affiche.html.twig',['Classroom'=>$Classroom]);
    
    }
    #[Route('Add', name:'app_Add')]
    public function Add(HttpFoundationRequest $request,ManagerRegistry $d,ClassroomRepository $repository):Response
{   $Classroom=$repository->findAll();
    $Classroom=new Classroom();
    $em=$d->getManager();
    $form=$this->CreateForm(ClassroomType::class,$Classroom);
    $form->add("Ajouter",SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted())
    {
        $em->persist($Classroom);
        $em->flush();
        return $this->redirectToRoute('app_Affiche');
    }
    return $this->render('Classroom/Add.html.twig',['f'=>$form->createView()]);

}
#[Route('edit/{id}', name:'app_edit')]
    function edit($id,HttpFoundationRequest $request,ManagerRegistry $d,ClassroomRepository $repository):response
    {
        $Classroom=$repository->find($id);
        $form=$this->createForm(ClassroomType::class,$Classroom);
        $form->add("modifier",SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$d->getManager();
            $em=flush();
            return $this-> redirectToRoute('app_Affiche');
        }
        return $this->render('Classroom/edit.html.twig',['f'=>$form->createView()]);
    }
    #[Route('delete/{id}', name: 'app_delete')]
    public function delete($id,ClassroomRepository $repository,ManagerRegistry $managerRegistry): Response 
    {
        $Classroom=$repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($Classroom);
        $em->flush();
        return new Response('removed');
    }
}
