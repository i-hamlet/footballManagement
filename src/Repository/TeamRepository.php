<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTableData(int $page, int $perPage, string $orderColumn = 'id', bool $sortDesc = true): array
    {

        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('t, p')
            ->from('App:Team', 't')
            ->orderBy("t.$orderColumn", $sortDesc ? 'DESC' : 'ASC')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->leftJoin('t.players', 'p')
            ->getQuery()->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);

        $paginator = new Paginator($q);
        $totalItems = $this->getEntityManager()->createQueryBuilder()
            ->select('count(t.id)')->from('App:Team', 't')
            ->getQuery()->getSingleScalarResult();

        $tableData = [
            'total_items' => $totalItems,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($totalItems / $perPage),
            'records' => [],
        ];

        foreach ($paginator as $team) {
            $tableData['records'][] = $team;
        }

        return $tableData;
    }
}
