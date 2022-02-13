<?php

namespace App\Tests;

use App\Entity\MotorCar;
use App\Service\MotorCarService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SearchMotorCarTest extends KernelTestCase
{
    public function getDoctrine(): ManagerRegistry
    {
        return static::getContainer()->get(ManagerRegistry::class);
    }

    public function assertListHasErrors(string $payload, ?MotorCar $motorCar): void
    {
        self::bootKernel();
        $container = static::getContainer()->get(MotorCarService::class);
        $resultService = $container->searchMotorCar($payload);

        $this->assertEquals($motorCar, $resultService);
    }

    public function testMotorCarNotFound(): void
    {
        $this->assertListHasErrors('rs10', null);
    }

    public function testMotorCarNoUniqueBrand(): void
    {
        $this->assertListHasErrors('ds3 serie5', null);
    }

    public function testMotorCarEmptyPayload(): void
    {
        $this->assertListHasErrors('', null);
    }

    public function testMotorCarRs4(): void
    {
        $motorCar = $this->getDoctrine()->getRepository(MotorCar::class)->findOneBy(['name'=>'rs4']);
        $this->assertListHasErrors('rs4 avant',$motorCar );
    }

    public function testMotorCarBMW(): void
    {
        $motorCar = $this->getDoctrine()->getRepository(MotorCar::class)->findOneBy(['name'=>'Serie 5']);
        $this->assertListHasErrors('Gran Turismo Série5',$motorCar);
    }

    public function testMotorCarDS3(): void
    {
        $motorCar = $this->getDoctrine()->getRepository(MotorCar::class)->findOneBy(['name'=>'Ds3']);
        $this->assertListHasErrors('ds 3 crossback',$motorCar);
    }
}
