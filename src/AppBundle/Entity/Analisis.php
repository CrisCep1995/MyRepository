<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection ;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints  as  Assert ;
/**
 * Analisis
 *
 * @ORM\Table(name="analisis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnalisisRepository")
 */
class Analisis implements \JsonSerializable
{

    /**
    *@ORM\ManyToMany(targetEntity="Paciente", mappedBy="analisis")
    *@ORM\JoinTable(name="Paciente_analisis")
    */
    private $paciente=null;
    public function __construct()
    {
        $this->paciente= new ArrayCollection();
    }
    public function getPaciente()
    {
        return $this->paciente;
    }

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


    /**
     * Get id
     *
     * @return int
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
     * @return Analisis
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
    public function jsonSerialize ()
    {
        return [
                    'id'=> $this->getId (),
                    'name' => $this->getName (),
        ];
    }
}

