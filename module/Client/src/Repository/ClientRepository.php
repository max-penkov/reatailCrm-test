<?php

declare(strict_types=1);

namespace Client\Repository;

use Client\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;
use Ds\Vector;
use Exception;

/**
 * Class ClientRepository
 * @package Client\Repository
 */
class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ClientRepository|EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository(Client::class);
    }

    public function fetchAll(int $limit, int $offset): Vector
    {
        $clients = new Vector();
        try {
            $qb = $this->repository->createQueryBuilder('c')->orderBy('c.createdAt', 'desc');

            $result = $qb->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

            if ($result === false) {
                return $clients;
            }

            foreach ($result as $item) {
                $clients->push($item);
            }

            return $clients;
        } catch (Exception $e) {
            throw new DomainException("Can't fetch clients", 0, $e->getMessage());
        }
    }

    public function getTotal(): int
    {
        $qb = $this->em->getConnection()->createQueryBuilder();
        $qb->select('count(id)')->from('client', 'c');

        $result = $qb->execute()->fetchColumn();

        return (int) $result;
    }

    /**
     * @param Client $client
     *
     * @return Client
     */
    public function save(Client $client): Client
    {
        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    /**
     * @param string $id
     *
     * @return Client
     */
    public function get(string $id): Client
    {
        /** @var Client $client */
        if (!$client = $this->repository->find($id)) {
            throw new DomainException('Client is not found.');
        }

        return $client;
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
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
    public function findOneBySomeField($value): ?Client
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
