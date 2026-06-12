<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260327023439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oauth2_access_token (identifier CHAR(80) NOT NULL, expiry DATETIME NOT NULL, user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL, revoked TINYINT NOT NULL, client VARCHAR(32) NOT NULL, INDEX IDX_454D9673C7440455 (client), PRIMARY KEY (identifier)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oauth2_authorization_code (identifier CHAR(80) NOT NULL, expiry DATETIME NOT NULL, user_identifier VARCHAR(128) DEFAULT NULL, scopes TEXT DEFAULT NULL, revoked TINYINT NOT NULL, client VARCHAR(32) NOT NULL, INDEX IDX_509FEF5FC7440455 (client), PRIMARY KEY (identifier)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oauth2_client (name VARCHAR(128) NOT NULL, secret VARCHAR(128) DEFAULT NULL, redirect_uris TEXT DEFAULT NULL, grants TEXT DEFAULT NULL, scopes TEXT DEFAULT NULL, active TINYINT NOT NULL, allow_plain_text_pkce TINYINT DEFAULT 0 NOT NULL, identifier VARCHAR(32) NOT NULL, PRIMARY KEY (identifier)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier CHAR(80) NOT NULL, expiry DATETIME NOT NULL, revoked TINYINT NOT NULL, access_token CHAR(80) DEFAULT NULL, INDEX IDX_4DD90732B6A2DD68 (access_token), PRIMARY KEY (identifier)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673C7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oauth2_authorization_code ADD CONSTRAINT FK_509FEF5FC7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732B6A2DD68 FOREIGN KEY (access_token) REFERENCES oauth2_access_token (identifier) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('INSERT INTO `oauth2_client` (`name`, `secret`, `redirect_uris`, `grants`, `scopes`, `active`, `allow_plain_text_pkce`, `identifier`) VALUES(\'wordliner\', \'8ff7b377e6df0e8362f891dfddf3c114809404fcb2a655279d41e920e1d11cc87a6a07314eeaa6b0e58ed8f7a6e814d37af1836d11c313aac315ae0046c3380e\', NULL, \'password refresh_token client_credentials\', \'read write\', 1, 0, \'8054c571f3304dfcbf922dfa8d8ba935\')');
        $this->addSql('INSERT INTO `user` (`email`, `roles`, `password`) VALUES(\'admin@wordliner.com\', \'["ROLE_ADMIN"]\', \'$2y$13$DcgSbp4ZprC2JKzi.2.ZnutUJxbQsL8EnUdoZOCaiGKuQJ05m5ZxG\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oauth2_access_token DROP FOREIGN KEY FK_454D9673C7440455');
        $this->addSql('ALTER TABLE oauth2_authorization_code DROP FOREIGN KEY FK_509FEF5FC7440455');
        $this->addSql('ALTER TABLE oauth2_refresh_token DROP FOREIGN KEY FK_4DD90732B6A2DD68');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_client');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('TRUNCATE `user`');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) DEFAULT NULL');
    }
}
