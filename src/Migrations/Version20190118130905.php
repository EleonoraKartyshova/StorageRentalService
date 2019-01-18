<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190118130905 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE storage_volume (id INT AUTO_INCREMENT NOT NULL, volume VARCHAR(20) NOT NULL, storage_type_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, address VARCHAR(50) NOT NULL, phone_number VARCHAR(20) NOT NULL, reservation_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goods_property (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goods (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, goods_property_id INT NOT NULL, details VARCHAR(255) NOT NULL, reservation_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, storage_type_id INT NOT NULL, storage_volume_id INT NOT NULL, user_id INT NOT NULL, goods_id INT NOT NULL, has_delivery TINYINT(1) DEFAULT \'0\', details VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storage_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, created_date DATE NOT NULL, is_active TINYINT(1) DEFAULT \'1\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(20) NOT NULL, password VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, company_title VARCHAR(50) NOT NULL, phone_number VARCHAR(20) NOT NULL, name VARCHAR(30) NOT NULL, address VARCHAR(50) NOT NULL, role SMALLINT DEFAULT 0, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE storage_volume');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE goods_property');
        $this->addSql('DROP TABLE goods');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE storage_type');
        $this->addSql('DROP TABLE user');
    }
}
