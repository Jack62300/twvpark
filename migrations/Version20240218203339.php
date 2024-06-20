<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218203339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registre_category_registre DROP FOREIGN KEY FK_634575F1E14FFAA');
        $this->addSql('ALTER TABLE registre_category_registre DROP FOREIGN KEY FK_634575F5678EFCA');
        $this->addSql('ALTER TABLE registre_registre_category DROP FOREIGN KEY FK_D65B91A15678EFCA');
        $this->addSql('ALTER TABLE registre_registre_category DROP FOREIGN KEY FK_D65B91A11E14FFAA');
        $this->addSql('DROP TABLE registre_category');
        $this->addSql('DROP TABLE registre_category_registre');
        $this->addSql('DROP TABLE registre_registre_category');
        $this->addSql('ALTER TABLE registre ADD categorie VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE registre_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE registre_category_registre (registre_category_id INT NOT NULL, registre_id INT NOT NULL, INDEX IDX_634575F5678EFCA (registre_id), INDEX IDX_634575F1E14FFAA (registre_category_id), PRIMARY KEY(registre_category_id, registre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE registre_registre_category (registre_id INT NOT NULL, registre_category_id INT NOT NULL, INDEX IDX_D65B91A15678EFCA (registre_id), INDEX IDX_D65B91A11E14FFAA (registre_category_id), PRIMARY KEY(registre_id, registre_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE registre_category_registre ADD CONSTRAINT FK_634575F1E14FFAA FOREIGN KEY (registre_category_id) REFERENCES registre_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registre_category_registre ADD CONSTRAINT FK_634575F5678EFCA FOREIGN KEY (registre_id) REFERENCES registre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registre_registre_category ADD CONSTRAINT FK_D65B91A15678EFCA FOREIGN KEY (registre_id) REFERENCES registre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registre_registre_category ADD CONSTRAINT FK_D65B91A11E14FFAA FOREIGN KEY (registre_category_id) REFERENCES registre_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registre DROP categorie');
    }
}
