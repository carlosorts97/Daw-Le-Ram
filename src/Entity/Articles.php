<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="fk_category_article", columns={"category"})})
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_article", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="retail_date", type="date", nullable=true)
     */
    private $retailDate;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id_category")
     * })
     */
    private $category;
    /**
     * @var \Brands
     *
     * @ORM\ManyToOne(targetEntity="Brands", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="brand", referencedColumnName="id_brand")
     * })
     */
    private $brand;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Sells", mappedBy="article")
     */
    private $sell;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="article")
     */
    private $image;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sell = new \Doctrine\Common\Collections\ArrayCollection();
        $this->image = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRetailDate(): ?\DateTimeInterface
    {
        return $this->retailDate;
    }

    public function setRetailDate(?\DateTimeInterface $retailDate): self
    {
        $this->retailDate = $retailDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Sells[]
     */
    public function getSell(): Collection
    {
        return $this->sell;
    }

    public function addSell(Sells $sell): self
    {
        if (!$this->sell->contains($sell)) {
            $this->sell[] = $sell;
            $sell->addArticle($this);
        }

        return $this;
    }

    public function removeSell(Sells $sell): self
    {
        if ($this->sell->contains($sell)) {
            $this->sell->removeElement($sell);
            $sell->removeArticle($this);
        }

        return $this;
    }

    public function getBrand(): ?Brands
    {
        return $this->brand;
    }

    public function setBrand(?Brands $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getImage(): Collection
    {
        return $this->image;
    }
    public function setImage(Images $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
        }
        return $this;
    }


}
