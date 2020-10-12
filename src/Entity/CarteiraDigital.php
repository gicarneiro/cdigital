<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Pessoa\Pessoa;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CarteiraDigitalRepository::class) * 
 * @ORM\Table(name="carteiras_digitais")
 */
class CarteiraDigital
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $saldo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $atualizadoEm;

    /**
     * @ORM\OneToOne(targetEntity=Pessoa::class, inversedBy="carteiraDigital", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getAtualizadoEm(): ?\DateTimeInterface
    {
        return $this->atualizadoEm;
    }

    public function setAtualizadoEm(\DateTimeInterface $atualizadoEm): self
    {
        $this->atualizadoEm = $atualizadoEm;

        return $this;
    }

    public function getProprietario(): ?Pessoa
    {
        return $this->proprietario;
    }

    public function setProprietario(Pessoa $proprietario): self
    {
        $this->proprietario = $proprietario;

        return $this;
    }
}
