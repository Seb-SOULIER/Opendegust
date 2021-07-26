<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210725131217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, offer_variation_id INT DEFAULT NULL, places JSON NOT NULL, price_variation_book JSON NOT NULL, total_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, vat DOUBLE PRECISION NOT NULL, total_places INT NOT NULL, INDEX IDX_E00CEDDE9395C3F3 (customer_id), UNIQUE INDEX UNIQ_E00CEDDEB6BBB063 (offer_variation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, offer_variation_id INT NOT NULL, start_at DATETIME NOT NULL, INDEX IDX_6EA9A146B6BBB063 (offer_variation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, INDEX IDX_64C19C112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_offer (category_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_C1E5C87712469DE2 (category_id), INDEX IDX_C1E5C87753C674EE (offer_id), PRIMARY KEY(category_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(50) DEFAULT NULL, city VARCHAR(90) DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, phone2 VARCHAR(45) DEFAULT NULL, website VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, registration_at DATETIME NOT NULL, civility INT DEFAULT NULL, lastname VARCHAR(45) DEFAULT NULL, firstname VARCHAR(45) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, know_us VARCHAR(255) DEFAULT NULL, gtc18 TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), UNIQUE INDEX UNIQ_81398E09E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_offer (customer_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_E7E3F2059395C3F3 (customer_id), INDEX IDX_E7E3F20553C674EE (offer_id), PRIMARY KEY(customer_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, short_description VARCHAR(255) DEFAULT NULL, long_description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, file_path VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8C9F3610A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, INDEX IDX_6354059A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, description_id INT DEFAULT NULL, contact_id INT NOT NULL, name VARCHAR(100) NOT NULL, picture VARCHAR(255) DEFAULT NULL, domain_name VARCHAR(100) NOT NULL, language JSON DEFAULT NULL, INDEX IDX_29D6873EA53A8AA (provider_id), UNIQUE INDEX UNIQ_29D6873ED9F966B (description_id), UNIQUE INDEX UNIQ_29D6873EE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_variation (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, price_variation JSON NOT NULL, capacity INT NOT NULL, duration TIME NOT NULL, price INT NOT NULL, current_vat DOUBLE PRECISION NOT NULL, available_places INT DEFAULT NULL, INDEX IDX_C15E4E2E53C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, provider_id INT DEFAULT NULL, category_id INT NOT NULL, name VARCHAR(45) NOT NULL, description VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_D34A04ADA53A8AA (provider_id), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT AUTO_INCREMENT NOT NULL, description_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, registration_at DATETIME NOT NULL, civility INT DEFAULT NULL, lastname VARCHAR(45) DEFAULT NULL, firstname VARCHAR(45) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, company VARCHAR(45) DEFAULT NULL, social_reason VARCHAR(45) DEFAULT NULL, siret INT DEFAULT NULL, vat_number INT DEFAULT NULL, opening JSON DEFAULT NULL, monthly_frequentation INT DEFAULT NULL, other_site JSON DEFAULT NULL, know_us VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_92C4739CE7927C74 (email), UNIQUE INDEX UNIQ_92C4739CD9F966B (description_id), UNIQUE INDEX UNIQ_92C4739CE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEB6BBB063 FOREIGN KEY (offer_variation_id) REFERENCES offer_variation (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146B6BBB063 FOREIGN KEY (offer_variation_id) REFERENCES offer_variation (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_offer ADD CONSTRAINT FK_C1E5C87712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_offer ADD CONSTRAINT FK_C1E5C87753C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE customer_offer ADD CONSTRAINT FK_E7E3F2059395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_offer ADD CONSTRAINT FK_E7E3F20553C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873ED9F966B FOREIGN KEY (description_id) REFERENCES description (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE offer_variation ADD CONSTRAINT FK_C15E4E2E53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CD9F966B FOREIGN KEY (description_id) REFERENCES description (id)');
        $this->addSql('ALTER TABLE provider ADD CONSTRAINT FK_92C4739CE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C112469DE2');
        $this->addSql('ALTER TABLE category_offer DROP FOREIGN KEY FK_C1E5C87712469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09E7A1254A');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EE7A1254A');
        $this->addSql('ALTER TABLE provider DROP FOREIGN KEY FK_92C4739CE7A1254A');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9395C3F3');
        $this->addSql('ALTER TABLE customer_offer DROP FOREIGN KEY FK_E7E3F2059395C3F3');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873ED9F966B');
        $this->addSql('ALTER TABLE provider DROP FOREIGN KEY FK_92C4739CD9F966B');
        $this->addSql('ALTER TABLE category_offer DROP FOREIGN KEY FK_C1E5C87753C674EE');
        $this->addSql('ALTER TABLE customer_offer DROP FOREIGN KEY FK_E7E3F20553C674EE');
        $this->addSql('ALTER TABLE offer_variation DROP FOREIGN KEY FK_C15E4E2E53C674EE');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEB6BBB063');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146B6BBB063');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A53A8AA');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059A53A8AA');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EA53A8AA');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA53A8AA');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_offer');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_offer');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_variation');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE provider');
    }
}
