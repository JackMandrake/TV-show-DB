<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function findAllOrderedByName()
    {
        // je crée "l'usine" à requete
        $queryBuilder = $this->createQueryBuilder('character');

        // fabrique une requete personnalisée
        $queryBuilder->orderBy('character.name', 'asc');

        // a la fin je recupère a la requete fabriquée
        $query = $queryBuilder->getQuery();

        // j'execute la requete pour en recupérer les resultats
        // getResult me renvoi une LISTE des resultats 
        return $query->getResult();
    }

    public function findOneWithCharacter($id)
    {
        $queryBuilder = $this->createQueryBuilder('character');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('character.id', $id)
        );

        $queryBuilder->leftJoin('character.tvShow', 'tvShows');
        $queryBuilder->addSelect('tvShows');

        $queryBuilder->orderBy('tvShows.title', 'asc');
        
        $query = $queryBuilder->getQuery();
        
        // me renvoi UN seul resultat 
        return $query->getOneOrNullResult();
    }

    
    // /**
    //  * @return Character[] Returns an array of Character objects
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
    */

    /*
    public function findOneBySomeField($value): ?Character
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
