<?php

namespace SD6Production\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use SD6Production\AppBundle\Entity\Advert;
use SD6Production\AppBundle\Entity\Member;
use SD6Production\AppBundle\Entity\Category;
use SD6Production\AppBundle\Entity\Image;

class DefaultController extends Controller
{
  public function indexAction()
  {
    //Récupère les 3 dernières adverts
    $em = $this->getDoctrine()->getManager();
    $listeAdverts = $em->getRepository('SD6ProductionAppBundle:Advert')->getAdvertNb(3);

    return $this->render('SD6ProductionAppBundle:Default:index.html.twig', array(
      'listeAdverts' => $listeAdverts,
    ));
  }
  public function productionsAction()
  {
    //Récupère toutes les productions
    $em = $this->getDoctrine()->getManager();
    $listeProductions = $em ->getRepository('SD6ProductionAppBundle:Advert')->getAdvertCategories('Productions');

    if(empty($listeProductions)){
      throw new NotFoundHttpException("Oups, no advert of type 'production' founded");
    }

    //Regarde si il y a des production épinglés (productions en haut de page)
    $productionsPinned = [];
    foreach ($listeProductions as $key => $production) {
      if ($production->getPinned() == 1 ) {
        $productionsPinned[] = $production;
      }
    }

    return $this->render('SD6ProductionAppBundle:Default:productions.html.twig', array(
      'listeProductions' => $listeProductions,
      'productionsPinned' => $productionsPinned,
    ));
  }

  public function prestationsAction()
  {
    return $this->render('SD6ProductionAppBundle:Default:prestations.html.twig');
  }

  public function equipeAction()
  {
    //Récupère tous les members de l'équipe
    $em = $this->getDoctrine()->getManager();
    $listeMembers = $em->getRepository('SD6ProductionAppBundle:Member')->findAll();

    if(empty($listeMembers)){
      throw new NotFoundHttpException("Oups, team not founded");
    }

    return $this->render('SD6ProductionAppBundle:Default:equipe.html.twig', array(
      'listeMembers' => $listeMembers,
    ));
  }

  public function actualitesAction()
  {
    //Récupère toutes les actualités
    $em = $this->getDoctrine()->getManager();
    $listeAdverts = $em ->getRepository('SD6ProductionAppBundle:Advert')->getAdvertCategories('Actualites');

    if(empty($listeAdverts)){
      throw new NotFoundHttpException("Oups, no advert of type 'actualites' founded");
    }

    //Regarde si il y a des actualités épinglés (productions en haut de page)
    $actualitesPinned = [];
    foreach ($listeAdverts as $key => $advert) {
      if ($advert->getPinned() == 1 ) {
        $actualitesPinned[] = $advert;
      }
    }

    return $this->render('SD6ProductionAppBundle:Default:actualites.html.twig', array(
      'listeAdverts' => $listeAdverts,
      'actualitesPinned' => $actualitesPinned
    ));
  }

  public function photosAction()
  {
    //Récupère les images de la galerie
    $em = $this->getDoctrine()->getManager();
    $category = $em->getRepository('SD6ProductionAppBundle:Category')->findOneByName('Galerie');
    $images = $em->getRepository('SD6ProductionAppBundle:Image')->findBy(array("category" => $category), array('date' => 'DESC'));

    if(empty($images)){
      throw new NotFoundHttpException("Oups, no picture founded");
    }

    return $this->render('SD6ProductionAppBundle:Default:photos.html.twig', array(
      'images' => $images,
    ));
  }

  public function castingAction()
  {
    //Récupère toutes adverts de casting
    $em = $this->getDoctrine()->getManager();
    $listeAdverts = $em->getRepository('SD6ProductionAppBundle:Advert')->getAdvertCategories('Casting');

    if(empty($listeAdverts)){
      throw new NotFoundHttpException("Oups, no advert of type 'casting' founded");
    }

    //Regarde si il y a des casting épinglés (productions en haut de page)
    $castingsPinned = [];
    foreach ($listeAdverts as $key => $advert) {
      if ($advert->getPinned() == 1 ) {
        $castingsPinned[] = $advert;
      }
    }

    return $this->render('SD6ProductionAppBundle:Default:casting.html.twig', array(
      'listeAdverts' => $listeAdverts,
      'castingsPinned' => $castingsPinned
    ));
  }

  public function detailAdvertAction($typeAdvert, $slugAdvert)
  {
    $em = $this->getDoctrine()->getManager();

    //Récupère l'advert à afficher
    $advert = $em->getRepository('SD6ProductionAppBundle:Advert')->findOneBySlug($slugAdvert);

    if(empty($advert)){
      throw new NotFoundHttpException("Oups, not found detail for the element : ".$slugAdvert);
    }

    $id = $advert->getId();

    //Récupère l'advert précédente et suivante
    $advertPrevious = $em->getRepository('SD6ProductionAppBundle:Advert')->findOneById($id - 1);
    $advertNext = $em->getRepository('SD6ProductionAppBundle:Advert')->findOneById($id + 1);

    return $this->render('SD6ProductionAppBundle:Default:detail.html.twig', array(
      'advert' => $advert,
      'advertPrevious' => $advertPrevious,
      'advertNext' => $advertNext
    ));
  }

  public function sideBarAction($limit)
  {
    //Récupère les dernières productions
    $em = $this->getDoctrine()->getManager();
    $listeProductions = $em ->getRepository('SD6ProductionAppBundle:Advert')->getAdvertNbWithCategory($limit, 'Productions');

    if(empty($listeProductions)){
      throw new NotFoundHttpException("Oups, no advert of type 'production' founded for the sideBar");
    }

    //Récupère les dernières actualités
    $em = $this->getDoctrine()->getManager();
    $listeActualites = $em ->getRepository('SD6ProductionAppBundle:Advert')->getAdvertNbWithCategory($limit, 'Actualites');

    if(empty($listeProductions)){
      throw new NotFoundHttpException("Oups, no advert of type 'actualites' founded for the sideBar");
    }

    return $this->render('SD6ProductionAppBundle:Default:side-bar.html.twig', array(
      'listeProductions' => $listeProductions,
      'listeActualites' => $listeActualites
    ));
  }

  public function mentionsLegalesAction()
  {
    return $this->render('SD6ProductionAppBundle:Default:mentions-legales.html.twig');
  }
}
