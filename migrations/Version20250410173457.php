<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410173457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE constante (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, valeur VARCHAR(50) NOT NULL, unite VARCHAR(50) NOT NULL, INDEX IDX_67194A6962FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, dossier_medical_id INT DEFAULT NULL, medecin_id INT NOT NULL, ordonnance_id INT DEFAULT NULL, observations VARCHAR(255) NOT NULL, INDEX IDX_964685A67750B79F (dossier_medical_id), INDEX IDX_964685A64F31A84 (medecin_id), UNIQUE INDEX UNIQ_964685A62BF23B8F (ordonnance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_3581EE626B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE medecin (id INT NOT NULL, code_medecin VARCHAR(50) NOT NULL, specialiste VARCHAR(25) NOT NULL, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, ordonnance_id INT DEFAULT NULL, code VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, posologie VARCHAR(50) NOT NULL, INDEX IDX_9A9C723A2BF23B8F (ordonnance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, observations VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE patient (id INT NOT NULL, code_patient VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE prestation (id INT AUTO_INCREMENT NOT NULL, responsable_prestation_id INT DEFAULT NULL, dossier_medical_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(100) NOT NULL, resultat VARCHAR(50) NOT NULL, date_realisation DATETIME NOT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_51C88FADE366EFB2 (responsable_prestation_id), INDEX IDX_51C88FAD7750B79F (dossier_medical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, secretaire_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, date_heure DATETIME NOT NULL, date_creation DATETIME NOT NULL, statut VARCHAR(25) NOT NULL, INDEX IDX_65E8AA0AA90F02B2 (secretaire_id), INDEX IDX_65E8AA0A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE responsable_prestation (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE secretaire (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(25) NOT NULL, nom VARCHAR(25) NOT NULL, is_is_active TINYINT(1) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE constante ADD CONSTRAINT FK_67194A6962FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consultation ADD CONSTRAINT FK_964685A67750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consultation ADD CONSTRAINT FK_964685A64F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consultation ADD CONSTRAINT FK_964685A62BF23B8F FOREIGN KEY (ordonnance_id) REFERENCES ordonnance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE626B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C6BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE medicament ADD CONSTRAINT FK_9A9C723A2BF23B8F FOREIGN KEY (ordonnance_id) REFERENCES ordonnance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prestation ADD CONSTRAINT FK_51C88FADE366EFB2 FOREIGN KEY (responsable_prestation_id) REFERENCES responsable_prestation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prestation ADD CONSTRAINT FK_51C88FAD7750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA90F02B2 FOREIGN KEY (secretaire_id) REFERENCES secretaire (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE responsable_prestation ADD CONSTRAINT FK_A5E17CADBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE secretaire ADD CONSTRAINT FK_7DB5C2D0BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE constante DROP FOREIGN KEY FK_67194A6962FF6CDF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consultation DROP FOREIGN KEY FK_964685A67750B79F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consultation DROP FOREIGN KEY FK_964685A64F31A84
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE consultation DROP FOREIGN KEY FK_964685A62BF23B8F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dossier_medical DROP FOREIGN KEY FK_3581EE626B899279
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C6BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE medicament DROP FOREIGN KEY FK_9A9C723A2BF23B8F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FADE366EFB2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE prestation DROP FOREIGN KEY FK_51C88FAD7750B79F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA90F02B2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6B899279
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE responsable_prestation DROP FOREIGN KEY FK_A5E17CADBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE secretaire DROP FOREIGN KEY FK_7DB5C2D0BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE constante
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE consultation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE dossier_medical
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE medecin
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE medicament
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ordonnance
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE patient
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE prestation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rendez_vous
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE responsable_prestation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE secretaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
