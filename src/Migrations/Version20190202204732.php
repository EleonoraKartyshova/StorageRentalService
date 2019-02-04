<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190202204732 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10B83297E7');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE goods DROP FOREIGN KEY FK_563B92DB83297E7');
        $this->addSql('ALTER TABLE goods DROP title');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT FK_563B92DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B7683595');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B7683595 FOREIGN KEY (goods_id) REFERENCES goods (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10B83297E7');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE goods DROP FOREIGN KEY FK_563B92DB83297E7');
        $this->addSql('ALTER TABLE goods ADD title VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT FK_563B92DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B7683595');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B7683595 FOREIGN KEY (goods_id) REFERENCES goods (id)');
    }
}
