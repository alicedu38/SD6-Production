<?php

namespace SD6Production\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* Category
*
* @ORM\Table(name="category")
* @ORM\Entity(repositoryClass="SD6Production\AppBundle\Repository\CategoryRepository")
*/
class Category
{
  /**
  * @Gedmo\Slug(fields={"name"})
  * @ORM\Column(name="slug", type="string", length=255, unique=true)
  */
  private $slug;

  /**
  * @var int
  *
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @var string
  *
  * @ORM\Column(name="name", type="string", length=255)
  */
  private $name;

  public function __toString() {
    return $this->name;
  }


  /**
  * Set slug
  *
  * @param string $slug
  *
  * @return Category
  */
  public function setSlug($slug)
  {
    $this->slug = $slug;

    return $this;
  }

  /**
  * Get slug
  *
  * @return string
  */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
  * Get id
  *
  * @return integer
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Set name
  *
  * @param string $name
  *
  * @return Category
  */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
  * Get name
  *
  * @return string
  */
  public function getName()
  {
    return $this->name;
  }
}
