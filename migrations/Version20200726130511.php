<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726130511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F569574A48');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F59D86650F');
        $this->addSql('DROP INDEX IDX_E46960F569574A48 ON favorites');
        $this->addSql('DROP INDEX IDX_E46960F59D86650F ON favorites');
        $this->addSql('ALTER TABLE favorites ADD user_id INT DEFAULT NULL, ADD recipe_id INT DEFAULT NULL, DROP user_id_id, DROP recipe_id_id');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F559D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_E46960F5A76ED395 ON favorites (user_id)');
        $this->addSql('CREATE INDEX IDX_E46960F559D8A214 ON favorites (recipe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F559D8A214');
        $this->addSql('DROP INDEX IDX_E46960F5A76ED395 ON favorites');
        $this->addSql('DROP INDEX IDX_E46960F559D8A214 ON favorites');
        $this->addSql('ALTER TABLE favorites ADD user_id_id INT DEFAULT NULL, ADD recipe_id_id INT DEFAULT NULL, DROP user_id, DROP recipe_id');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F569574A48 FOREIGN KEY (recipe_id_id) REFERENCES recipe (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E46960F569574A48 ON favorites (recipe_id_id)');
        $this->addSql('CREATE INDEX IDX_E46960F59D86650F ON favorites (user_id_id)');
    }
}
