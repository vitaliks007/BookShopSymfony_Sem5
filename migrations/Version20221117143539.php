<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117143539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD new VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book_order DROP FOREIGN KEY FK_FBEB86E1A76ED395');
        $this->addSql('DROP INDEX IDX_FBEB86E1A76ED395 ON book_order');
        $this->addSql('ALTER TABLE book_order DROP user_id');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP role, CHANGE username username VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(31) DEFAULT NULL, CHANGE surname surname VARCHAR(31) DEFAULT NULL, CHANGE birthday birthday DATE DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author DROP new');
        $this->addSql('ALTER TABLE book_order ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_order ADD CONSTRAINT FK_FBEB86E1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FBEB86E1A76ED395 ON book_order (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(31) NOT NULL, DROP roles, CHANGE username username VARCHAR(63) NOT NULL, CHANGE password password VARCHAR(63) NOT NULL, CHANGE name name VARCHAR(63) NOT NULL, CHANGE surname surname VARCHAR(63) DEFAULT NULL, CHANGE birthday birthday DATE NOT NULL');
    }
}
