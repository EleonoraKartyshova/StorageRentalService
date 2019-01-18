<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190118175031 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE storage_volume CHANGE storage_type_id storage_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE storage_volume ADD CONSTRAINT FK_829939DFB270BFF1 FOREIGN KEY (storage_type_id) REFERENCES storage_type (id)');
        $this->addSql('CREATE INDEX IDX_829939DFB270BFF1 ON storage_volume (storage_type_id)');
        $this->addSql('ALTER TABLE delivery CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3781EC10B83297E7 ON delivery (reservation_id)');
        $this->addSql('ALTER TABLE goods CHANGE goods_property_id goods_property_id INT DEFAULT NULL, CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT FK_563B92DD830C13E FOREIGN KEY (goods_property_id) REFERENCES goods_property (id)');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT FK_563B92DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_563B92DD830C13E ON goods (goods_property_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_563B92DB83297E7 ON goods (reservation_id)');
        $this->addSql('ALTER TABLE reservation CHANGE storage_type_id storage_type_id INT DEFAULT NULL, CHANGE storage_volume_id storage_volume_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE goods_id goods_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B270BFF1 FOREIGN KEY (storage_type_id) REFERENCES storage_type (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495567C311E5 FOREIGN KEY (storage_volume_id) REFERENCES storage_volume (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B7683595 FOREIGN KEY (goods_id) REFERENCES goods (id)');
        $this->addSql('CREATE INDEX IDX_42C84955B270BFF1 ON reservation (storage_type_id)');
        $this->addSql('CREATE INDEX IDX_42C8495567C311E5 ON reservation (storage_volume_id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955B7683595 ON reservation (goods_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10B83297E7');
        $this->addSql('DROP INDEX UNIQ_3781EC10B83297E7 ON delivery');
        $this->addSql('ALTER TABLE delivery CHANGE reservation_id reservation_id INT NOT NULL');
        $this->addSql('ALTER TABLE goods DROP FOREIGN KEY FK_563B92DD830C13E');
        $this->addSql('ALTER TABLE goods DROP FOREIGN KEY FK_563B92DB83297E7');
        $this->addSql('DROP INDEX IDX_563B92DD830C13E ON goods');
        $this->addSql('DROP INDEX UNIQ_563B92DB83297E7 ON goods');
        $this->addSql('ALTER TABLE goods CHANGE goods_property_id goods_property_id INT NOT NULL, CHANGE reservation_id reservation_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B270BFF1');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495567C311E5');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B7683595');
        $this->addSql('DROP INDEX IDX_42C84955B270BFF1 ON reservation');
        $this->addSql('DROP INDEX IDX_42C8495567C311E5 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('DROP INDEX UNIQ_42C84955B7683595 ON reservation');
        $this->addSql('ALTER TABLE reservation CHANGE storage_type_id storage_type_id INT NOT NULL, CHANGE storage_volume_id storage_volume_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE goods_id goods_id INT NOT NULL');
        $this->addSql('ALTER TABLE storage_volume DROP FOREIGN KEY FK_829939DFB270BFF1');
        $this->addSql('DROP INDEX IDX_829939DFB270BFF1 ON storage_volume');
        $this->addSql('ALTER TABLE storage_volume CHANGE storage_type_id storage_type_id INT NOT NULL');
    }
}
