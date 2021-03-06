<?php

namespace App\Repository;

use App\Entity\Pessoa\Pessoa;
use App\Entity\PessoaFisica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PessoaFisica|null find($id, $lockMode = null, $lockVersion = null)
 * @method PessoaFisica|null findOneBy(array $criteria, array $orderBy = null)
 * @method PessoaFisica[]    findAll()
 * @method PessoaFisica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PessoaRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PessoaFisica::class);
    }

    public function findOneById(int $id): ?Pessoa {
        return $this->entityRepository->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
