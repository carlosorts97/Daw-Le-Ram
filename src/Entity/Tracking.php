<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Tracking
 *
 * @ORM\Table(name="tracking")
 * @ORM\Entity(repositoryClass="App\Repository\TrackingRepository")
 */
class Tracking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tracking", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTracking;
    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=true)
     */
    private $state;
    /**
     * @var string|null
     *
     * @ORM\Column(name="ttracking_company", type="string", length=255, nullable=true)
     */
    private $ttrackingCompany;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_date", type="date", nullable=false)
     */
    private $departureDate;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_llegada", type="date", nullable=true)
     */
    private $fechaLlegada;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="devolution_date", type="date", nullable=true)
     */
    private $devolutionDate;

    public function getIdTracking(): ?int
    {
        return $this->idTracking;
    }
    public function getState(): ?string
    {
        return $this->state;
    }
    public function setState(?string $state): self
    {
        $this->state = $state;
        return $this;
    }
    public function getTtrackingCompany(): ?string
    {
        return $this->ttrackingCompany;
    }
    public function setTtrackingCompany(?string $ttrackingCompany): self
    {
        $this->ttrackingCompany = $ttrackingCompany;
        return $this;
    }
    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }
    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;
        return $this;
    }
    public function getFechaLlegada(): ?\DateTimeInterface
    {
        return $this->fechaLlegada;
    }
    public function setFechaLlegada(?\DateTimeInterface $fechaLlegada): self
    {
        $this->fechaLlegada = $fechaLlegada;
        return $this;
    }
    public function getDevolutionDate(): ?\DateTimeInterface
    {
        return $this->devolutionDate;
    }
    public function setDevolutionDate(?\DateTimeInterface $devolutionDate): self
    {
        $this->devolutionDate = $devolutionDate;
        return $this;
    }
}