<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Validation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ValidationTest extends KernelTestCase
{
    public function getEntity(): Validation
        {
            $user = new User();
            return (new Validation())
                ->setUser($user)
                ->setCode('1234');
        }

    public function assertHasError(Validation $validation, int $number = 0)
    {
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($validation);
        $this->assertCount($number, $error);
    }

    public function testValidValidation()
    {
        $this->assertHasError($this->getEntity(), 0);
    }

    public function testInvalidValidationCode()
    {   
        $this->assertHasError($this->getEntity()->setCode('123a'), 1);
        $this->assertHasError($this->getEntity()->setCode('12345'), 1);
        $this->assertHasError($this->getEntity()->setCode('123'), 1);
    }

    public function testInvalidBlankValidationCode()
    {   
        $this->assertHasError($this->getEntity()->setCode(''), 1);
    }
}