<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190314152559 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP facebook_id, CHANGE email email VARCHAR(30) DEFAULT NULL, CHANGE company_title company_title VARCHAR(50) DEFAULT NULL, CHANGE phone_number phone_number VARCHAR(20) DEFAULT NULL, CHANGE address address VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD facebook_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE company_title company_title VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE phone_number phone_number VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
