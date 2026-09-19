-- ====================================================================
-- Kre8 Luxury Barbershop - Master Normalized Database Schema
-- Phase 4: PHP, MySQL & Real Barbershop Functionality
-- ====================================================================

CREATE DATABASE IF NOT EXISTS `kre8_barbershop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `kre8_barbershop`;

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Admins Table
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `role` ENUM('superadmin', 'manager', 'receptionist') DEFAULT 'superadmin',
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `last_login` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_admin_username` (`username`),
    INDEX `idx_admin_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Customers Table
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `phone` VARCHAR(30) NOT NULL,
    `vip_status` ENUM('standard', 'vip', 'member') DEFAULT 'standard',
    `notes` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_customer_email` (`email`),
    INDEX `idx_customer_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Service Categories Table
DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Services Table
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT UNSIGNED NULL,
    `title` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `price` DECIMAL(10,2) NOT NULL,
    `duration_minutes` INT UNSIGNED DEFAULT 45,
    `duration` VARCHAR(50) DEFAULT '45 Mins',
    `description` TEXT NOT NULL,
    `features_json` JSON NULL,
    `icon_name` VARCHAR(50) DEFAULT 'scissors',
    `badge` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    `is_featured` TINYINT(1) DEFAULT 1,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_service_slug` (`slug`),
    INDEX `idx_service_active` (`is_active`),
    CONSTRAINT `fk_service_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Master Barbers Table
DROP TABLE IF EXISTS `barbers`;
CREATE TABLE `barbers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `role` VARCHAR(100) NOT NULL,
    `bio` TEXT NULL,
    `experience_years` INT UNSIGNED DEFAULT 5,
    `specialty` VARCHAR(150) DEFAULT 'Master Stylist & Beard Artist',
    `image_url` VARCHAR(255) NOT NULL,
    `instagram_url` VARCHAR(255) DEFAULT '#',
    `facebook_url` VARCHAR(255) DEFAULT '#',
    `twitter_url` VARCHAR(255) DEFAULT '#',
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_barber_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Business Hours Table
DROP TABLE IF EXISTS `business_hours`;
CREATE TABLE `business_hours` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `day_of_week` ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL UNIQUE,
    `display_name` VARCHAR(20) NOT NULL,
    `open_time` TIME NOT NULL,
    `close_time` TIME NOT NULL,
    `is_closed` TINYINT(1) DEFAULT 0,
    `slot_interval_minutes` INT UNSIGNED DEFAULT 30,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Appointments Table
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT UNSIGNED NULL,
    `service_id` INT UNSIGNED NULL,
    `barber_id` INT UNSIGNED NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `phone` VARCHAR(30) NOT NULL,
    `service_name` VARCHAR(150) NOT NULL,
    `barber_name` VARCHAR(150) DEFAULT 'Any Available Master',
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `end_time` TIME NULL,
    `message` TEXT NULL,
    `status` ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    `admin_notes` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_appt_date_time` (`appointment_date`, `appointment_time`),
    INDEX `idx_appt_barber_date` (`barber_id`, `appointment_date`),
    INDEX `idx_appt_status` (`status`),
    CONSTRAINT `fk_appt_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_appt_service` FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_appt_barber` FOREIGN KEY (`barber_id`) REFERENCES `barbers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Gallery Portfolio Table
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `category_slug` VARCHAR(100) NOT NULL,
    `desc_text` VARCHAR(255) NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `thumbnail_url` VARCHAR(255) NOT NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Testimonials Table
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_name` VARCHAR(150) NOT NULL,
    `client_role` VARCHAR(100) DEFAULT 'VIP Client',
    `client_avatar` VARCHAR(255) NULL,
    `content` TEXT NOT NULL,
    `rating` TINYINT UNSIGNED DEFAULT 5,
    `service_received` VARCHAR(150) DEFAULT 'Signature Haircut & Beard Sculpt',
    `is_active` TINYINT(1) DEFAULT 1,
    `is_featured` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Contact Messages Table
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `phone` VARCHAR(30) NULL,
    `subject` VARCHAR(150) NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `ip_address` VARCHAR(45) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_msg_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Website Settings Table
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT NULL,
    `setting_group` VARCHAR(50) DEFAULT 'general',
    `description` VARCHAR(255) NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Newsletter Subscribers Table
DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE `newsletter_subscribers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
