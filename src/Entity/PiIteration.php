<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="piiteration")
 * @ORM\Entity(repositoryClass="App\Repository\PiIterationRepository")
 */
class PiIteration {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  /**
   * @ORM\Column(type="integer")
   * @Assert\NotBlank()
   *
   */
  private $digit;
  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   *
   */
  private $pi;

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }
  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * @return mixed
   */
  public function getDigit()
  {
    return $this->digit;
  }
  /**
   * @param mixed $digit
   */
  public function setDigit($digit)
  {
    $this->digit = $digit;
  }
  /**
   * @return mixed
   */
  public function getPi()
  {
    return $this->pi;
  }
  /**
   * @param mixed $pi
   */
  public function setPi($pi)
  {
    $this->pi = $pi;
  }
}
