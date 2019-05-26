<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_stock", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStock;

    /**
     * @var int|null
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    public function getIdStock(): ?int
    {
        return $this->idStock;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
    public function AddStock(): self
    {
        $stock = $this->stock;
        $this->stock = $stock +1;

        return $this;
    }
    public function RemoveStock(): self
    {
        $stock = $this->stock;
        if($this->getStock()>0) {
            $this->stock = $stock - 1;
        }

        return $this;
    }


}
