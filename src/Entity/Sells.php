<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sells
 *
 * @ORM\Table(name="sells", indexes={@ORM\Index(name="fk_seller_sells", columns={"seller"}), @ORM\Index(name="fk_buyer_sells", columns={"buyer"})})
 * @ORM\Entity(repositoryClass="App\Repository\SellsRepository")
 */
class Sells
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_sell", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSell;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sell_date", type="date", nullable=false)
     */
    private $sellDate;
    /**
     * @var float
     *
     * @ORM\Column(name="totalPaid", type="float", precision=10, scale=2, nullable=false)
     */
    private $totalPaid;
    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $size;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="buyer", referencedColumnName="id_user")
     * })
     */
    private $buyer;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seller", referencedColumnName="id_user")
     * })
     */
    private $seller;

    /**
     * @var \Articles
     *

     * @ORM\OneToOne(targetEntity="Articles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article", referencedColumnName="id_article")
     * })
     */
    private $article;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->article = new \Doctrine\Common\Collections\ArrayCollection();
        $fechaActual= new \DateTime();
        $this->setSellDate($fechaActual);
    }

    public function getIdSell(): ?int
    {
        return $this->idSell;
    }
    public function setIdSell(?int $idSell): self
    {
        $this->idSell = $idSell;

        return $this;
    }
    public function getSellDate(): ?\DateTimeInterface
    {
        return $this->sellDate;
    }

    public function setSellDate(\DateTimeInterface $sellDate): self
    {
        $this->sellDate = $sellDate;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): self
    {
        $this->seller = $seller;

        return $this;
    }


    public function getArticle()
    {
        return $this->article;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalPaid(): float
    {
        return $this->totalPaid;
    }

    /**
     * @param float $totalPaid
     */
    public function setTotalPaid(float $totalPaid): void
    {
        $this->totalPaid = $totalPaid;
    }
    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size)
    {
        $this->size = $size;
    }

}