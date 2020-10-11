<?php

namespace App\Repository;

use App\Entity\CarteiraDigital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
* @method CarteiraDigital|null find($id, $lockMode = null, $lockVersion = null)
* @method CarteiraDigital|null findOneBy(array $criteria, array $orderBy = null)
* @method CarteiraDigital[]    findAll()
* @method CarteiraDigital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class CarteiraDigitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarteiraDigital::class);
    }
    
    /**
     * Encontra uma carteira digital através do alias (cpf)
     */
    public function findByProprietarioAlias($alias){
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT p, c
            FROM App\Entity\CarteiraDigital p
            LEFT JOIN p.proprietario c
            WHERE c.cpf = :cpf'
            )->setParameter('cpf', $alias);
            
            return $query->getOneOrNullResult();
        }
        
        // /**
        //  * @return CarteiraDigital[] Returns an array of CarteiraDigital objects
        //  */
        /*
        public function findByExampleField($value)
        {
            return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
        }
        
        
        /*
        public function findOneBySomeField($value): ?CarteiraDigital
        {
            return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
        }
        */
    }
    