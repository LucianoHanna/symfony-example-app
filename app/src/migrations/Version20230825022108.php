<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825022108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create orders tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, table_identifier VARCHAR(255) NOT NULL, ordered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, order_rel_id INT NOT NULL, quantity INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_52EA1F098D85B118 (order_rel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D85B118 FOREIGN KEY (order_rel_id) REFERENCES `order` (id)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D85B118');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
    }
}
