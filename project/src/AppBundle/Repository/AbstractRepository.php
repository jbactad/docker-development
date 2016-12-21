<?php
/**
 * Created by jbactad.
 * Date: 12/19/2016
 * Time: 3:54 PM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\EntityInterface;

/**
 * Class AbstractRepository
 *
 * @package AppBundle\Repository
 */
abstract class AbstractRepository extends EntityRepository
{
    /**
     * The current query builder of the repository.
     *
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * The alias to use for the current entity.
     *
     * @var string
     */
    protected $entityAlias;

    /**
     * The limit to use for the query.
     *
     * @var int
     */
    protected $limit = 25;

    /**
     * The offset to use for the query.
     *
     * @var int
     */
    protected $offset = 0;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return AbstractRepository
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     *
     * @return AbstractRepository
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function paginate($limit, $offset)
    {
        $this->setLimit($limit)
            ->setOffset($offset);

        return $this;
    }

    /**
     * Get or create a query builder.
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        if (!$this->queryBuilder) {

            $this->queryBuilder = $this->createQueryBuilder($this->getEntityAlias());
        }

        return $this->queryBuilder;
    }

    /**
     * Returns an array of entities in object form.
     *
     * @param int $hydrationMode
     *
     * @return array|Entity[]
     */
    public function getObjectResults($hydrationMode = Query::HYDRATE_OBJECT)
    {
        return $this->getQueryBuilder()
            ->setMaxResults($this->getLimit())
            ->setFirstResult($this->getOffset())
            ->getQuery()
            ->getResult($hydrationMode);
    }

    /**
     * Return an array of entities in scalar form.
     *
     * @return array|array[]
     */
    public function getScalarResults()
    {
        return $this->getQueryBuilder()
            ->setMaxResults($this->getLimit())
            ->setFirstResult($this->getOffset())
            ->getQuery()
            ->getArrayResult();
    }

    public function addOrder($sortBy, $order = 'ASC')
    {
        return $this->getQueryBuilder()->addOrderBy($this->getEntityAlias().'.'.$sortBy, $order);
    }

    /**
     * @param null $hydrationMode
     *
     * @return mixed
     */
    public function getOneOrNullResult($hydrationMode = null)
    {
        return $this->getQueryBuilder()
            ->getQuery()
            ->getOneOrNullResult($hydrationMode);
    }

    /**
     * @return string
     */
    protected function getEntityAlias()
    {
        if (!$this->entityAlias) {
            /**
             * @var EntityInterface $className
             */
            $className = $this->getClassName();

            $this->entityAlias = $className::getAlias();
        }

        return $this->entityAlias;
    }

    /**
     * @return QueryBuilder
     */
    protected function newQueryBuilder()
    {
        return $this->getQueryBuilder();
    }

}
