<?php

namespace App\Entity;

use App\Repository\ThesectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Thesection
 *
 * @ORM\Table(name="thesection", uniqueConstraints={@ORM\UniqueConstraint(name="thesectionslug_UNIQUE", columns={"thesectionslug"})})
 * @ORM\Entity(repositoryClass=ThesectionRepository::class)
 */
class Thesection
{
    /**
     * @var int
     *
     * @ORM\Column(name="idthesection", type="smallint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idthesection;

    /**
     * @var string
     *
     * @ORM\Column(name="thesectiontitle", type="string", length=60, nullable=false)
     */
    private $thesectiontitle;

    /**
     * @var string
     *
     * @ORM\Column(name="thesectionslug", type="string", length=60, nullable=false)
     */
    private $thesectionslug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="thesectiondesc", type="string", length=300, nullable=true)
     */
    private $thesectiondesc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Thearticle", inversedBy="thesectionIdthesection")
     * @ORM\JoinTable(name="thesection_has_thearticle",
     *   joinColumns={
     *     @ORM\JoinColumn(name="thesection_idthesection", referencedColumnName="idthesection")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="thearticle_idthearticle", referencedColumnName="idthearticle")
     *   }
     * )
     */
    private $thearticleIdthearticle;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->thearticleIdthearticle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdthesection(): ?int
    {
        return $this->idthesection;
    }

    public function getThesectiontitle(): ?string
    {
        return $this->thesectiontitle;
    }

    public function setThesectiontitle(string $thesectiontitle): self
    {
        $this->thesectiontitle = $thesectiontitle;

        return $this;
    }

    public function getThesectionslug(): ?string
    {
        return $this->thesectionslug;
    }

    public function setThesectionslug(string $thesectionslug): self
    {
        $this->thesectionslug = $thesectionslug;

        return $this;
    }

    public function getThesectiondesc(): ?string
    {
        return $this->thesectiondesc;
    }

    public function setThesectiondesc(?string $thesectiondesc): self
    {
        $this->thesectiondesc = $thesectiondesc;

        return $this;
    }

    /**
     * @return Collection<int, Thearticle>
     */
    public function getThearticleIdthearticle(): Collection
    {
        return $this->thearticleIdthearticle;
    }

    public function addThearticleIdthearticle(Thearticle $thearticleIdthearticle): self
    {
        if (!$this->thearticleIdthearticle->contains($thearticleIdthearticle)) {
            $this->thearticleIdthearticle[] = $thearticleIdthearticle;
        }

        return $this;
    }

    public function removeThearticleIdthearticle(Thearticle $thearticleIdthearticle): self
    {
        $this->thearticleIdthearticle->removeElement($thearticleIdthearticle);

        return $this;
    }

    public function __tostring():string {
        return $this->getThesectiontitle();
    }
}
