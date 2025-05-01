<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501191444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE skill_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee CHANGE name name VARCHAR(100) NOT NULL, CHANGE lastname lastname VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill DROP FOREIGN KEY FK_B630E90E8C03F15C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill DROP FOREIGN KEY FK_B630E90E5585C142
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill ADD id INT AUTO_INCREMENT NOT NULL, ADD score SMALLINT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill ADD CONSTRAINT FK_B630E90E8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill ADD CONSTRAINT FK_B630E90E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE skill ADD skill_category_id INT NOT NULL, CHANGE title name VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477AC58042E FOREIGN KEY (skill_category_id) REFERENCES skill_category (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5E3DE477AC58042E ON skill (skill_category_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT '(DC2Type:json)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477AC58042E
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE skill_category
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill DROP FOREIGN KEY FK_B630E90E8C03F15C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill DROP FOREIGN KEY FK_B630E90E5585C142
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON employee_skill
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill DROP id, DROP score
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill ADD CONSTRAINT FK_B630E90E8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill ADD CONSTRAINT FK_B630E90E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee_skill ADD PRIMARY KEY (employee_id, skill_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin` COMMENT '(DC2Type:json)'
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5E3DE477AC58042E ON skill
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE skill DROP skill_category_id, CHANGE name title VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE employee CHANGE name name VARCHAR(80) NOT NULL, CHANGE lastname lastname VARCHAR(80) NOT NULL
        SQL);
    }
}
