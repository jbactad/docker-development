<?php
/**
 * Created by jbactad.
 * Date: 12/18/2016
 * Time: 4:02 PM
 */

namespace AppBundle\DataFixtures\Processor;


use Nelmio\Alice\ProcessorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;

class UserProcessor implements ProcessorInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $encoder;

    /**
     * UserProcessor constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function preProcess($object)
    {
        if (false === $object instanceof User) {
            return;
        }
        $object->setPassword($this->encoder->encodePassword($object, $object->getPassword()));
    }

    /**
     * @inheritDoc
     */
    public function postProcess($object)
    {
        // TODO: Implement postProcess() method.
    }

}
