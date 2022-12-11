<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221112204734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33169CCBE9A');
        $this->addSql('DROP INDEX IDX_CBE5A33169CCBE9A ON book');
        $this->addSql('ALTER TABLE book CHANGE author_id_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
        $this->addSql('ALTER TABLE book_order DROP FOREIGN KEY FK_FBEB86E19D86650F');
        $this->addSql('DROP INDEX IDX_FBEB86E19D86650F ON book_order');
        $this->addSql('ALTER TABLE book_order CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_order ADD CONSTRAINT FK_FBEB86E1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FBEB86E1A76ED395 ON book_order (user_id)');
        $this->addSql('ALTER TABLE book_order_product DROP FOREIGN KEY FK_40D995EA71868B2E');
        $this->addSql('ALTER TABLE book_order_product DROP FOREIGN KEY FK_40D995EAAE2DA5D6');
        $this->addSql('DROP INDEX IDX_40D995EA71868B2E ON book_order_product');
        $this->addSql('DROP INDEX IDX_40D995EAAE2DA5D6 ON book_order_product');
        $this->addSql('ALTER TABLE book_order_product ADD book_id INT NOT NULL, ADD book_order_id INT NOT NULL, DROP book_id_id, DROP book_order_id_id');
        $this->addSql('ALTER TABLE book_order_product ADD CONSTRAINT FK_40D995EA16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_order_product ADD CONSTRAINT FK_40D995EA94607B61 FOREIGN KEY (book_order_id) REFERENCES book_order (id)');
        $this->addSql('CREATE INDEX IDX_40D995EA16A2B381 ON book_order_product (book_id)');
        $this->addSql('CREATE INDEX IDX_40D995EA94607B61 ON book_order_product (book_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_order_product DROP FOREIGN KEY FK_40D995EA16A2B381');
        $this->addSql('ALTER TABLE book_order_product DROP FOREIGN KEY FK_40D995EA94607B61');
        $this->addSql('DROP INDEX IDX_40D995EA16A2B381 ON book_order_product');
        $this->addSql('DROP INDEX IDX_40D995EA94607B61 ON book_order_product');
        $this->addSql('ALTER TABLE book_order_product ADD book_id_id INT NOT NULL, ADD book_order_id_id INT NOT NULL, DROP book_id, DROP book_order_id');
        $this->addSql('ALTER TABLE book_order_product ADD CONSTRAINT FK_40D995EA71868B2E FOREIGN KEY (book_id_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE book_order_product ADD CONSTRAINT FK_40D995EAAE2DA5D6 FOREIGN KEY (book_order_id_id) REFERENCES book_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_40D995EA71868B2E ON book_order_product (book_id_id)');
        $this->addSql('CREATE INDEX IDX_40D995EAAE2DA5D6 ON book_order_product (book_order_id_id)');
        $this->addSql('ALTER TABLE book_order DROP FOREIGN KEY FK_FBEB86E1A76ED395');
        $this->addSql('DROP INDEX IDX_FBEB86E1A76ED395 ON book_order');
        $this->addSql('ALTER TABLE book_order CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_order ADD CONSTRAINT FK_FBEB86E19D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FBEB86E19D86650F ON book_order (user_id_id)');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B ON book');
        $this->addSql('ALTER TABLE book CHANGE author_id author_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33169CCBE9A FOREIGN KEY (author_id_id) REFERENCES author (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CBE5A33169CCBE9A ON book (author_id_id)');
    }
}
