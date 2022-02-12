<?php

namespace App\Service;

use App\Entity\MotorCar;
use Doctrine\Persistence\ManagerRegistry;

class MotorCarService extends HelperService
{

    public function searchMotorCar(string $payload) :?MotorCar
    {
        $carName = $this->formatSearchPayload($payload);
        $result = !empty($carName);

        if($result){
            foreach ($carName as $name){
                $motorCar = $this->doctrine->getRepository(MotorCar::class)->findOneBy(['name' => $name]);
                if($motorCar!==null){
                    return $motorCar;
                }
            }
        }

        return null;
    }


}