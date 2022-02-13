<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212173017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Rs3');");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Rs4');");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Cabriolet')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Q2')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Q3')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Q5')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Q7')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Q8')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','R8')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Rs3')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Rs4')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Rs5')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Rs7')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S3')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S4')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S4 Avant')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S4 Cabriolet')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S5')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S7')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','S8')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','SQ5')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','SQ7')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Tt')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','Tts')");
        $this->addSql("insert into motor_car (brand,name) values ('Audi','V8')");

        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'M3')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'M4')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'M5')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'M535')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'M6')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'M635')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 1')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 2')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 3')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 4')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 5')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 6')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 7')");
        $this->addSql("insert into motor_car (brand,name) values ('BMW', 'Serie 8')");

        $this->addSql("insert into motor_car (brand,name) value('Citroen','C1')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C15')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C2')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C25')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C25D')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C25E')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C25TD')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C3')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C3 Aircross')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C3 Picasso')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C4')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C4 Picasso')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C5')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C6')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','C8')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','Ds3')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','Ds4')");
        $this->addSql("insert into motor_car (brand,name) value('Citroen','Ds')");

        $this->addSql("insert into category (name) value('MotorCar')");
        $this->addSql("insert into category (name) value('RealEstate')");
        $this->addSql("insert into category (name) value('Work')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('delete from category where id > 0');
        $this->addSql('delete from motor_car where id > 0');
    }
}
