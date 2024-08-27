<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsuarioFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $usuario = new Usuario();
            $usuario->setNombre("Usuario" . $i);
            $usuario->setEmail("usuario" . $i . "@gmail.com");
            $usuario->setPassword('$2y$13$w5eluTLF0P5EgVHlwSI3L.Manm3RAdsOd1KK6Isv1fcAt1WDhg8sa');
            $manager->persist($usuario);
        }

        $manager->flush();
    }
}
