<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623092927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee_department (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE employee_user (id VARCHAR(36) NOT NULL, department_id VARCHAR(36) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_384A9C0EAE80F5DF ON employee_user (department_id)');
        $this->addSql('CREATE TABLE payroll_contract (user_id VARCHAR(36) NOT NULL, department_bonus_id VARCHAR(36) DEFAULT NULL, salary INT NOT NULL, work_start_at DATE NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE INDEX IDX_BC1C896250EA4C4C ON payroll_contract (department_bonus_id)');
        $this->addSql('CREATE TABLE payroll_department_bonus (department_id VARCHAR(36) NOT NULL, type VARCHAR(16) NOT NULL, value INT NOT NULL, PRIMARY KEY(department_id))');
        $this->addSql('CREATE TABLE payroll_projection (user_id VARCHAR(36) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, department_name VARCHAR(255) NOT NULL, bonus_type VARCHAR(16) NOT NULL, base_salary INT NOT NULL, bonus_salary INT NOT NULL, total_salary INT NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE INDEX first_name ON payroll_projection (first_name)');
        $this->addSql('CREATE INDEX last_name ON payroll_projection (last_name)');
        $this->addSql('CREATE INDEX department_name ON payroll_projection (department_name)');
        $this->addSql('ALTER TABLE employee_user ADD CONSTRAINT FK_384A9C0EAE80F5DF FOREIGN KEY (department_id) REFERENCES employee_department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payroll_contract ADD CONSTRAINT FK_BC1C896250EA4C4C FOREIGN KEY (department_bonus_id) REFERENCES payroll_department_bonus (department_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE employee_user DROP CONSTRAINT FK_384A9C0EAE80F5DF');
        $this->addSql('ALTER TABLE payroll_contract DROP CONSTRAINT FK_BC1C896250EA4C4C');
        $this->addSql('DROP TABLE employee_department');
        $this->addSql('DROP TABLE employee_user');
        $this->addSql('DROP TABLE payroll_contract');
        $this->addSql('DROP TABLE payroll_department_bonus');
        $this->addSql('DROP TABLE payroll_projection');
    }
}
