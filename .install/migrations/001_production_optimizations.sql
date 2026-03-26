-- =============================================================================
-- StewardsCredit Production Migration: 001_production_optimizations.sql
-- Description: Adds performance indexes, foreign key constraints, the alerts
--              table for notifications, and the trans_type column on transaction.
-- Run this script ONCE against your production database before deploying.
-- =============================================================================

-- -----------------------------------------------------------------------------
-- 1. ADD PERFORMANCE INDEXES
--    These cover the most frequent WHERE and ORDER BY clauses identified in
--    the application code, particularly in Post_model and Comment_model.
-- -----------------------------------------------------------------------------

-- transaction table: account_id is used in nearly every financial query
ALTER TABLE `transaction`
    ADD INDEX IF NOT EXISTS `idx_transaction_account_id` (`account_id`),
    ADD INDEX IF NOT EXISTS `idx_transaction_trans_date` (`trans_date`),
    ADD INDEX IF NOT EXISTS `idx_transaction_p_method` (`p_method`);

-- comments table: post_id and status are the primary filters for transaction lists
ALTER TABLE `comments`
    ADD INDEX IF NOT EXISTS `idx_comments_post_id` (`post_id`),
    ADD INDEX IF NOT EXISTS `idx_comments_userid` (`userid`),
    ADD INDEX IF NOT EXISTS `idx_comments_status` (`status`),
    ADD INDEX IF NOT EXISTS `idx_comments_trans_date` (`trans_date`);

-- posts table: user_id and category_id are used in account lookups
ALTER TABLE `posts`
    ADD INDEX IF NOT EXISTS `idx_posts_user_id` (`user_id`),
    ADD INDEX IF NOT EXISTS `idx_posts_category_id` (`category_id`),
    ADD INDEX IF NOT EXISTS `idx_posts_status` (`status`);

-- interest table: post_id + date range queries are the core of interest calc
-- (post_id + datestring unique key already exists; add date-only index for range scans)
ALTER TABLE `interest`
    ADD INDEX IF NOT EXISTS `idx_interest_post_id` (`post_id`);

-- users table: email and username lookups for login and search
ALTER TABLE `users`
    ADD INDEX IF NOT EXISTS `idx_users_email` (`email`),
    ADD INDEX IF NOT EXISTS `idx_users_username` (`username`);


-- -----------------------------------------------------------------------------
-- 2. ADD trans_type COLUMN TO transaction TABLE
--    Required by the bug fix in Comment_model.php that separates the ledger
--    direction (Income/Expense) from the account direction (CR/DR).
-- -----------------------------------------------------------------------------

ALTER TABLE `transaction`
    ADD COLUMN IF NOT EXISTS `trans_type` VARCHAR(5) NULL DEFAULT NULL
        COMMENT 'CR = credit to account, DR = debit from account'
        AFTER `type`;


-- -----------------------------------------------------------------------------
-- 3. CREATE THE alerts TABLE
--    Supports the Alerts feature (previously a static UI mockup).
--    Stores scheduled payment reminders tied to a client account.
-- -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `alerts` (
    `alert_id`      INT(11)         NOT NULL AUTO_INCREMENT,
    `post_id`       INT(11)         NOT NULL COMMENT 'The account (post) this alert is for',
    `user_id`       INT(11)         NOT NULL COMMENT 'The client user ID',
    `alert_name`    VARCHAR(255)    NOT NULL,
    `start_date`    DATE            NOT NULL,
    `frequency`     ENUM('monthly','weekly','daily') NOT NULL DEFAULT 'monthly',
    `last_sent`     DATETIME        NULL DEFAULT NULL,
    `next_due`      DATE            NOT NULL,
    `status`        TINYINT(1)      NOT NULL DEFAULT 1 COMMENT '1=active, 0=inactive',
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`alert_id`),
    INDEX `idx_alerts_post_id`  (`post_id`),
    INDEX `idx_alerts_user_id`  (`user_id`),
    INDEX `idx_alerts_next_due` (`next_due`),
    INDEX `idx_alerts_status`   (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- -----------------------------------------------------------------------------
-- 4. CREATE THE account_attachments TABLE
--    Supports the Attachments feature (previously a static UI mockup).
-- -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `account_attachments` (
    `attachment_id` INT(11)         NOT NULL AUTO_INCREMENT,
    `post_id`       INT(11)         NOT NULL COMMENT 'The account (post) this file belongs to',
    `user_id`       INT(11)         NOT NULL COMMENT 'Admin who uploaded the file',
    `file_name`     VARCHAR(255)    NOT NULL,
    `file_path`     VARCHAR(500)    NOT NULL,
    `file_type`     VARCHAR(100)    NULL DEFAULT NULL,
    `file_size`     INT(11)         NULL DEFAULT NULL COMMENT 'Size in bytes',
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`attachment_id`),
    INDEX `idx_attachments_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- -----------------------------------------------------------------------------
-- 5. FOREIGN KEY CONSTRAINTS
--    Applied AFTER indexes to ensure referential integrity.
--    NOTE: Only add these if your existing data is already clean.
--    If you have orphaned records, clean them first with:
--      DELETE FROM comments WHERE post_id NOT IN (SELECT id FROM posts);
--      DELETE FROM transaction WHERE account_id NOT IN (SELECT id FROM posts);
-- -----------------------------------------------------------------------------

-- comments.post_id -> posts.id
ALTER TABLE `comments`
    ADD CONSTRAINT IF NOT EXISTS `fk_comments_post_id`
        FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- transaction.account_id -> posts.id
ALTER TABLE `transaction`
    ADD CONSTRAINT IF NOT EXISTS `fk_transaction_account_id`
        FOREIGN KEY (`account_id`) REFERENCES `posts`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- alerts.post_id -> posts.id
ALTER TABLE `alerts`
    ADD CONSTRAINT IF NOT EXISTS `fk_alerts_post_id`
        FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- alerts.user_id -> users.id
ALTER TABLE `alerts`
    ADD CONSTRAINT IF NOT EXISTS `fk_alerts_user_id`
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- account_attachments.post_id -> posts.id
ALTER TABLE `account_attachments`
    ADD CONSTRAINT IF NOT EXISTS `fk_attachments_post_id`
        FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

-- =============================================================================
-- END OF MIGRATION
-- =============================================================================
