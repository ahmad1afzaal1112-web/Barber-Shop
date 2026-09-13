-- ====================================================================
-- Kre8 Luxury Barbershop - Database Schema & Seed Data
-- ====================================================================

CREATE DATABASE IF NOT EXISTS `kre8_barbershop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `kre8_barbershop`;

-- 1. Appointments Table
CREATE TABLE IF NOT EXISTS `appointments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(25) NOT NULL,
    `service` VARCHAR(100) NOT NULL,
    `barber` VARCHAR(100) DEFAULT 'Any Available Master',
    `appointment_date` DATE NOT NULL,
    `appointment_time` VARCHAR(20) NOT NULL,
    `message` TEXT NULL,
    `status` ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Services Table
CREATE TABLE IF NOT EXISTS `services` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `price` DECIMAL(10,2) NOT NULL,
    `duration` VARCHAR(50) DEFAULT '45 Mins',
    `description` TEXT NOT NULL,
    `icon_name` VARCHAR(50) DEFAULT 'scissors',
    `badge` VARCHAR(50) NULL,
    `sort_order` INT DEFAULT 0,
    `is_featured` TINYINT(1) DEFAULT 1,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Team Members Table
CREATE TABLE IF NOT EXISTS `team_members` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `role` VARCHAR(100) NOT NULL,
    `bio` TEXT NULL,
    `experience_years` INT DEFAULT 5,
    `specialty` VARCHAR(150) DEFAULT 'Master Stylist & Beard Artist',
    `image_url` VARCHAR(255) NOT NULL,
    `instagram_url` VARCHAR(255) DEFAULT '#',
    `facebook_url` VARCHAR(255) DEFAULT '#',
    `twitter_url` VARCHAR(255) DEFAULT '#',
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `client_name` VARCHAR(150) NOT NULL,
    `client_role` VARCHAR(100) DEFAULT 'VIP Client',
    `client_avatar` VARCHAR(255) NULL,
    `content` TEXT NOT NULL,
    `rating` TINYINT DEFAULT 5,
    `service_received` VARCHAR(100) DEFAULT 'Signature Haircut & Beard Sculpt',
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Products Table
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `old_price` DECIMAL(10,2) NULL,
    `rating` DECIMAL(2,1) DEFAULT 5.0,
    `reviews_count` INT DEFAULT 24,
    `image_url` VARCHAR(255) NOT NULL,
    `badge` VARCHAR(50) NULL,
    `description` TEXT NULL,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Gallery Items Table
CREATE TABLE IF NOT EXISTS `gallery` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `image_url` VARCHAR(255) NOT NULL,
    `thumbnail_url` VARCHAR(255) NOT NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. FAQ Table
CREATE TABLE IF NOT EXISTS `faqs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `question` VARCHAR(255) NOT NULL,
    `answer` TEXT NOT NULL,
    `category` VARCHAR(100) DEFAULT 'General',
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Blog Posts Table
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `excerpt` TEXT NOT NULL,
    `content` LONGTEXT NULL,
    `author` VARCHAR(100) DEFAULT 'Alexander Pierce',
    `author_role` VARCHAR(100) DEFAULT 'Master Barber',
    `category` VARCHAR(100) DEFAULT 'Grooming Tips',
    `image_url` VARCHAR(255) NOT NULL,
    `published_date` DATE NOT NULL,
    `comments_count` INT DEFAULT 3,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Newsletter Subscriptions
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ====================================================================
-- SEED DATA
-- ====================================================================

-- Services Seed Data
INSERT INTO `services` (`title`, `slug`, `price`, `duration`, `description`, `icon_name`, `badge`, `sort_order`) VALUES
('Classic Haircut & Wash', 'classic-haircut', 35.00, '45 Mins', 'Precision scissor and clipper cut tailored to your face shape, followed by refreshing organic shampoo and scalp massage.', 'scissors', 'POPULAR', 1),
('Signature Beard Grooming', 'beard-grooming', 25.00, '30 Mins', 'Hot towel wrap, precise edge lining, artisanal trimming, and conditioning with premium argan & cedarwood beard oil.', 'razor', 'TRENDING', 2),
('Traditional Royal Shave', 'royal-shave', 40.00, '40 Mins', 'Luxury straight razor shave featuring dual hot towel steaming, eucalyptus pre-shave cream, and cold towel finish.', 'brush', 'LUXURY', 3),
('Hair Color & Grey Camo', 'hair-color', 50.00, '60 Mins', 'Subtle natural grey blending or full custom color transformation crafted by our master colorists.', 'comb', NULL, 4),
('Youth Executive Cut', 'youth-cut', 28.00, '35 Mins', 'Sharp and modern haircuts for younger gentlemen under 16, finished with style styling pomade.', 'scissors', NULL, 5),
('The Full VIP Package', 'vip-package', 95.00, '90 Mins', 'Complete royal treatment: hair cut, beard styling, hot towel shave, botanical facial scrub, and complimentary beverage.', 'crown', 'BEST VALUE', 6);

-- Team Members Seed Data
INSERT INTO `team_members` (`name`, `role`, `bio`, `experience_years`, `specialty`, `image_url`, `sort_order`) VALUES
('Alexander Pierce', 'Founder & Master Stylist', 'Over 14 years perfecting precision scissor work and traditional Italian straight-razor shaving techniques.', 14, 'Classic Scissor Cuts & Fades', 'assets/images/team/barber-1.jpg', 1),
('Marcus Vance', 'Senior Beard Artisan', 'Specialist in bespoke beard sculpts, textured pompadours, and luxury skin treatments.', 9, 'Beard Sculpting & Hot Shave', 'assets/images/team/barber-2.jpg', 2),
('David Thorne', 'Creative Hair Stylist', 'Expert in modern fades, taper cuts, grey camouflage, and avant-garde editorial hair designs.', 8, 'Modern Fades & Hair Coloring', 'assets/images/team/barber-3.jpg', 3);

-- Testimonials Seed Data
INSERT INTO `testimonials` (`client_name`, `client_role`, `content`, `rating`, `service_received`) VALUES
('James Sterling', 'Executive Director', 'The attention to detail at Kre8 is unmatched anywhere in the city. The royal shave is a masterclass in relaxation and precision. I won’t trust my hair to anyone else.', 5, 'The Full VIP Package'),
('Robert Chen', 'Architect & Designer', 'Step inside and you immediately feel the refined atmosphere. Marcus sculpted my beard to perfection. The complimentary bourbon and hot towels are extraordinary.', 5, 'Signature Beard Grooming'),
('Michael Anderson', 'Creative Producer', 'Flawless fade, incredible hospitality, and true craftsmen who understand styling nuances. Book in advance because their popularity is well-earned!', 5, 'Classic Haircut & Wash');

-- Products Seed Data
INSERT INTO `products` (`name`, `category`, `price`, `old_price`, `rating`, `reviews_count`, `image_url`, `badge`) VALUES
('Matte Finish Clay Pomade', 'Styling', 24.00, 28.00, 4.9, 38, 'assets/images/products/product-1.jpg', 'BESTSELLER'),
('Organic Cedarwood Beard Oil', 'Beard Care', 22.00, NULL, 5.0, 52, 'assets/images/products/product-2.jpg', 'ORGANIC'),
('Artisanal Sandalwood Shaving Cream', 'Shaving', 26.00, 30.00, 4.8, 19, 'assets/images/products/product-3.jpg', 'HOT'),
('Ergonomic Damascus Steel Razor', 'Accessories', 75.00, 89.00, 5.0, 44, 'assets/images/products/product-4.jpg', 'PREMIUM');

-- FAQs Seed Data
INSERT INTO `faqs` (`question`, `answer`, `category`, `sort_order`) VALUES
('Do I need to book an appointment in advance?', 'While walk-ins are always warmly welcomed based on barber availability, we strongly recommend booking in advance through our online system to guarantee your preferred master barber and time slot.', 'Booking', 1),
('What premium products do you use during service?', 'We exclusively curate and apply certified organic, paraben-free grooming essentials, including top-tier Italian aftershaves, British botanical pomades, and cold-pressed organic beard elixirs.', 'Services', 2),
('How early should I arrive for my appointment?', 'We suggest arriving 10-15 minutes prior to your booking. This gives you time to unwind in our lounge, enjoy a complimentary beverage, and consult with your stylist.', 'General', 3),
('Can I request a specific barber for my visit?', 'Absolutely! When booking online or over the phone, you can select your preferred stylist from our roster of master barbers.', 'Booking', 4),
('What is your appointment cancellation policy?', 'We kindly request at least 4 hours notice for any rescheduling or cancellations so we can accommodate gentlemen on our waiting list.', 'Policy', 5);

-- Blog Posts Seed Data
INSERT INTO `blog_posts` (`title`, `slug`, `excerpt`, `published_date`, `category`, `image_url`) VALUES
('The Art of the Classic Straight Razor Shave', 'art-of-classic-straight-razor-shave', 'Discover why the century-old straight razor ritual remains the ultimate indulgence for modern gentlemen.', '2026-08-15', 'Grooming Guide', 'assets/images/blog/blog-1.jpg'),
('How to Maintain a Sharp Beard Between Visits', 'how-to-maintain-sharp-beard', 'Essential trimming techniques, daily hydration secrets, and the exact brush strokes to keep your beard immaculate.', '2026-08-28', 'Beard Care', 'assets/images/blog/blog-2.jpg'),
('Trending Men’s Hairstyles of the Season', 'trending-mens-hairstyles', 'From classic low tapers to textured modern mullets, explore the standout hair aesthetics redefining luxury barbershop craft.', '2026-09-05', 'Style Trends', 'assets/images/blog/blog-3.jpg');
