<?php

namespace App\Entity\Pessoa;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 */
class PessoaFisica extends Pessoa {
    
    /**
     * @ORM\Column(type="string", length=11)
     */
    private $cpf;

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }
}
