<?php

namespace SD6Production\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SD6Production\AppBundle\Entity\Image;
use SD6Production\AppBundle\Form\ImageType;


class ImageController extends Controller
{
  public function imageAction()
  {
    //Récupère toutes les images
    $em = $this->getDoctrine()->getManager();

    $images = $em->getRepository('SD6ProductionAppBundle:Image')->findAll();

    return $this->render('SD6ProductionAdminBundle:Image:image.html.twig', array(
      'images' => $images
    ));
  }

  /*Ajouter image*/
  public function addAction(Request $request){
    $image = new Image();
    $formImage = $this->get('form.factory')->create(new ImageType(), $image);

    $formImage->handleRequest($request);

    if ($formImage->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Image enregistrée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));

    }

    return $this->render('SD6ProductionAdminBundle:Image:ajouter.html.twig', array(
      'formImage' => $formImage->createView(),
    ));
  }

  /*Editer image*/
  public function editeAction(Request $request, $idImage)
  {
    $em = $this->getDoctrine()->getManager();
    $image = $em->getRepository('SD6ProductionAppBundle:Image')->findOneById($idImage);

    $formImage = $this->get('form.factory')->create(new ImageType(), $image);
    $formImage->handleRequest($request);

    if ($formImage->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Image modifiée.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }

    return $this->render('SD6ProductionAdminBundle:Image:editer.html.twig', array(
      'formImage' => $formImage->createView(),
      'image' => $image,
    ));
  }

  /*Supprimer une image*/
  public function deleteAction($idImage, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $image = $em->getRepository('SD6ProductionAppBundle:Image')->find($idImage);

    $em = $this->getDoctrine()->getManager();

    // Si l'element n'existe pas, on affiche une erreur 404
    if ($idImage === null) {
      throw new NotFoundHttpException("Element d'id ".$idImage." n'existe pas.");
    }else{
      $em->remove($image);
      $em->flush();

      $request->getSession()->getFlashBag()->add('succes', 'Element supprimé.');

      return $this->redirect($this->generateUrl('sd6_production_app_homepage'));
    }
  }
}
