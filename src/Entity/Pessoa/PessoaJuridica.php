<?php

namespace App\Entity\Pessoa;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity
 */
class PessoaJuridica extends Pessoa{


    /**
     * @ORM\Column(type="string", length=11)
     */
    private $cnpj;

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;

        return $this;
    }
}
