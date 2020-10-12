<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransacaoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TransacaoRepository::class)
 */
class Transacao
{
    
    public function __construct()
    {
        $this->data = new \DateTime(); 
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data;

    /**
     * @ORM\OneToOne(targetEntity=CarteiraDigital::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $origem;

    /**
     * @ORM\OneToOne(targetEntity=CarteiraDigital::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $destino;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=2)
     */
    private $valor;

    /**
     * Not Mapped
     */
    private $destinoAlias;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getOrigem(): ?CarteiraDigital
    {
        return $this->origem;
    }

    public function setOrigem(CarteiraDigital $origem): self
    {
        $this->origem = $origem;

        return $this;
    }

    public function getDestino(): ?CarteiraDigital
    {
        return $this->destino;
    }

    public function setDestino(CarteiraDigital $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getDestinoAlias(): ?string
    {
        return $this->destinoAlias;
    }

    public function setDestinoAlias(string $destinoAlias): self
    {
        $this->destinoAlias = $destinoAlias;

        return $this;
    }
}
