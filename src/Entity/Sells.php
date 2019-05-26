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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="buyer", referencedColumnName="id_user")
     * })
     */
    private $buyer;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seller", referencedColumnName="id_user")
     * })
     */
    private $seller;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Articles", inversedBy="sell")
     * @ORM\JoinTable(name="details_sell",
     *   joinColumns={
     *     @ORM\JoinColumn(name="sell", referencedColumnName="id_sell")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="article", referencedColumnName="id_article")
     *   }
     * )
     */
    private $article;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->article = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdSell(): ?int
    {
        return $this->idSell;
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

    public function getBuyer(): ?Users
    {
        return $this->buyer;
    }

    public function setBuyer(?Users $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getSeller(): ?Users
    {
        return $this->seller;
    }

    public function setSeller(?Users $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticle(): Collection
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

}
