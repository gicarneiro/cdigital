<?php

namespace App\Entity\Pessoa;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CarteiraDigital;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PessoaRepository::class)
 * @ORM\Table(name="pessoas")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="tipo", type="integer")
 * @ORM\DiscriminatorMap({"1" = "PessoaFisica", "2" = "PessoaJuridica"})
 */
abstract class Pessoa {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $senha;


    /**
     * @ORM\OneToOne(targetEntity=CarteiraDigital::class, mappedBy="proprietario", cascade={"persist", "remove"})
     */
    private $carteiraDigital;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getCarteiraDigital(): ?CarteiraDigital
    {
        return $this->carteiraDigital;
    }
}
