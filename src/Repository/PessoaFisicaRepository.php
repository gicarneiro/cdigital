<?php

namespace App\Repository;

use App\Entity\PessoaFisica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PessoaFisica|null find($id, $lockMode = null, $lockVersion = null)
 * @method PessoaFisica|null findOneBy(array $criteria, array $orderBy = null)
 * @method PessoaFisica[]    findAll()
 * @method PessoaFisica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PessoaFisicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PessoaFisica::class);
    }

    // /**
    //  * @return PessoaFisica[] Returns an array of PessoaFisica objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PessoaFisica
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
