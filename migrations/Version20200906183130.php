<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906183130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, technique_id INT DEFAULT NULL, series_id INT DEFAULT NULL, file_name VARCHAR(180) NOT NULL, title VARCHAR(180) NOT NULL, slug VARCHAR(180) NOT NULL, creation_date DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, active TINYINT(1) NOT NULL, type TINYTEXT NOT NULL, etsy_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C53D045FD7DF1668 (file_name), UNIQUE INDEX UNIQ_C53D045F2B36786B (title), UNIQUE INDEX UNIQ_C53D045F989D9B62 (slug), INDEX IDX_C53D045F1F8ACB26 (technique_id), INDEX IDX_C53D045F5278319C (series_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_tag (image_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_5B6367D03DA5256D (image_id), INDEX IDX_5B6367D0BAD26311 (tag_id), PRIMARY KEY(image_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1F8ACB26 FOREIGN KEY (technique_id) REFERENCES technique (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5278319C FOREIGN KEY (series_id) REFERENCES series (id)');
        $this->addSql('ALTER TABLE image_tag ADD CONSTRAINT FK_5B6367D03DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_tag ADD CONSTRAINT FK_5B6367D0BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_tag DROP FOREIGN KEY FK_5B6367D03DA5256D');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_tag');
    }
}
