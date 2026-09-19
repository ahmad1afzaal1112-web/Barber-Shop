<?php
/**
 * Master Database Migration & Seeder Runner
 * Kre8 Luxury Barbershop
 */

header('Content-Type: text/plain; charset=utf-8');

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3307';
$dbname = getenv('DB_NAME') ?: 'kre8_barbershop';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

echo "====================================================\n";
echo "Kre8 Luxury Barbershop - Master Migration & Seeding\n";
echo "====================================================\n\n";

try {
    // 1. Connect without dbname to create if needed
    $pdoRoot = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "[1/4] Creating database `{$dbname}` if not exists...\n";
    $pdoRoot->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "      -> Database `{$dbname}` ready.\n\n";

    // 2. Connect to the database
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // 3. Execute Schema
    echo "[2/4] Executing schema.sql tables...\n";
    $schemaFile = __DIR__ . '/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new Exception("schema.sql not found at {$schemaFile}");
    }
    
    $sql = file_get_contents($schemaFile);
    $pdo->exec($sql);
    echo "      -> All 12 tables created successfully.\n\n";

    // 4. Seed Initial Data
    echo "[3/4] Seeding initial records...\n";

    // 4a. Admin User
    $adminUser = 'admin';
    $adminEmail = 'care@kre8barber.com';
    $adminPass = 'Admin@Kre8Luxury2026!';
    $adminHash = password_hash($adminPass, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO `admins` (`username`, `email`, `password_hash`, `full_name`, `role`, `status`) VALUES (?, ?, ?, ?, 'superadmin', 'active') ON DUPLICATE KEY UPDATE `password_hash` = VALUES(`password_hash`)");
    $stmt->execute([$adminUser, $adminEmail, $adminHash, 'Master Concierge Admin']);
    echo "      -> Seeded Admin User: {$adminUser} (Password: {$adminPass})\n";

    // 4b. Service Categories
    $categories = [
        ['name' => 'Haircut & Styling', 'slug' => 'haircut-styling', 'description' => 'Precision scissor cuts, modern fades, and luxury wash treatments.', 'sort_order' => 1],
        ['name' => 'Beard & Shave', 'slug' => 'beard-shave', 'description' => 'Artisanal beard sculpting, straight razor edging, and royal hot towel rituals.', 'sort_order' => 2],
        ['name' => 'Color & Grooming', 'slug' => 'color-grooming', 'description' => 'Natural grey blending, scalp treatments, and complete executive packages.', 'sort_order' => 3],
    ];
    $catStmt = $pdo->prepare("INSERT INTO `service_categories` (`name`, `slug`, `description`, `sort_order`, `is_active`) VALUES (?, ?, ?, ?, 1) ON DUPLICATE KEY UPDATE `description` = VALUES(`description`)");
    foreach ($categories as $cat) {
        $catStmt->execute([$cat['name'], $cat['slug'], $cat['description'], $cat['sort_order']]);
    }

    // 4c. 8 Signature Services
    $services = [
        [
            'category_id' => 1,
            'title' => 'Classic Haircut',
            'slug' => 'classic-haircut',
            'price' => 35.00,
            'duration_minutes' => 45,
            'duration' => '45 Mins',
            'description' => 'Tailored precision scissor and clipper cut crafted to compliment your natural head shape and personal aesthetic.',
            'features' => ['Consultation & scissor work', 'Clean taper & neck line', 'Invigorating hair wash', 'Matte clay styling finish'],
            'icon_name' => 'scissors',
            'badge' => 'SIGNATURE',
            'sort_order' => 1
        ],
        [
            'category_id' => 1,
            'title' => 'Skin Fade',
            'slug' => 'skin-fade',
            'price' => 40.00,
            'duration_minutes' => 50,
            'duration' => '50 Mins',
            'description' => 'Seamless gradient fade down to skin using foil shavers and precision clippers, balanced with textured scissor top work.',
            'features' => ['Zero skin taper blend', 'Foil shaver finish', 'Crisp hairline contour', 'Cool tonic scalp rinse'],
            'icon_name' => 'scissors',
            'badge' => 'POPULAR',
            'sort_order' => 2
        ],
        [
            'category_id' => 2,
            'title' => 'Beard Styling',
            'slug' => 'beard-styling',
            'price' => 28.00,
            'duration_minutes' => 30,
            'duration' => '30 Mins',
            'description' => 'Sculpted beard shaping, sharp straight razor cheek lines, hot towel steam, and nourishing organic botanical oils.',
            'features' => ['Beard length sculpting', 'Razor cheek & neck line', 'Hot eucalyptus towel', 'Organic cedarwood oil'],
            'icon_name' => 'razor',
            'badge' => 'TRENDING',
            'sort_order' => 3
        ],
        [
            'category_id' => 2,
            'title' => 'Hair & Beard Combo',
            'slug' => 'hair-beard-combo',
            'price' => 60.00,
            'duration_minutes' => 75,
            'duration' => '75 Mins',
            'description' => 'The ultimate complete grooming overhaul combining our signature haircut with bespoke beard shaping and hot towel finish.',
            'features' => ['Full precision haircut', 'Beard trim & razor lines', 'Double hot towel steam', 'Styling clay & beard elixir'],
            'icon_name' => 'crown',
            'badge' => 'BEST VALUE',
            'sort_order' => 4
        ],
        [
            'category_id' => 2,
            'title' => 'Royal Shave',
            'slug' => 'royal-shave',
            'price' => 45.00,
            'duration_minutes' => 45,
            'duration' => '45 Mins',
            'description' => 'Traditional Italian straight razor wet shave with pre-shave essential oils, rich badger brush lather, and cold stone compression.',
            'features' => ['Hot essential oil towel', 'Badger brush rich lather', 'Straight razor shave', 'Post-shave cold rose tonic'],
            'icon_name' => 'brush',
            'badge' => 'LUXURY',
            'sort_order' => 5
        ],
        [
            'category_id' => 1,
            'title' => 'Kids Haircut',
            'slug' => 'kids-haircut',
            'price' => 25.00,
            'duration_minutes' => 30,
            'duration' => '30 Mins',
            'description' => 'Gentle, patient, and modern styling for young gentlemen under 12 years old with complimentary styling candy.',
            'features' => ['Patient consultation', 'Clean scissor/clipper blend', 'Light pomade styling', 'Lounge treat'],
            'icon_name' => 'scissors',
            'badge' => null,
            'sort_order' => 6
        ],
        [
            'category_id' => 1,
            'title' => 'Hair Styling',
            'slug' => 'hair-styling',
            'price' => 20.00,
            'duration_minutes' => 25,
            'duration' => '25 Mins',
            'description' => 'Wash, blow-dry sculpting, and high-hold pomade finish for special events, photography shoots, or executive meetings.',
            'features' => ['Shampoo wash & rinse', 'Blow dry volume sculpting', 'Premium matte or shine pomade', 'Texture grooming spray'],
            'icon_name' => 'comb',
            'badge' => null,
            'sort_order' => 7
        ],
        [
            'category_id' => 3,
            'title' => 'Premium Grooming',
            'slug' => 'premium-grooming',
            'price' => 95.00,
            'duration_minutes' => 90,
            'duration' => '90 Mins',
            'description' => 'The definitive executive package: haircut, beard sculpting, royal shave, exfoliating facial scrub, and complimentary craft beverage.',
            'features' => ['Signature haircut & wash', 'Full beard sculpt or shave', 'Exfoliating charcoal scrub', 'Complimentary single malt beverage'],
            'icon_name' => 'award',
            'badge' => 'EXCLUSIVE',
            'sort_order' => 8
        ],
    ];

    $srvStmt = $pdo->prepare("INSERT INTO `services` (`category_id`, `title`, `slug`, `price`, `duration_minutes`, `duration`, `description`, `features_json`, `icon_name`, `badge`, `sort_order`, `is_featured`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1) ON DUPLICATE KEY UPDATE `price` = VALUES(`price`), `description` = VALUES(`description`), `features_json` = VALUES(`features_json`)");
    foreach ($services as $s) {
        $srvStmt->execute([
            $s['category_id'],
            $s['title'],
            $s['slug'],
            $s['price'],
            $s['duration_minutes'],
            $s['duration'],
            $s['description'],
            json_encode($s['features']),
            $s['icon_name'],
            $s['badge'],
            $s['sort_order']
        ]);
    }
    echo "      -> Seeded 8 Signature Services.\n";

    // 4d. Master Barbers
    $barbers = [
        [
            'name' => 'Alexander Pierce',
            'slug' => 'alexander-pierce',
            'role' => 'Founder & Master Barber',
            'bio' => '14+ years mastering Italian straight razor rituals and precision European scissor contouring.',
            'experience_years' => 14,
            'specialty' => 'Classic Scissor Cuts & Fades',
            'image_url' => 'assets/images/team/barber-1.jpg',
            'sort_order' => 1
        ],
        [
            'name' => 'Marcus Vance',
            'slug' => 'marcus-vance',
            'role' => 'Senior Beard Sculptor',
            'bio' => 'Celebrated specialist in razor-sharp beard fading, steam towels, and organic botanical beard hydration.',
            'experience_years' => 9,
            'specialty' => 'Beard Sculpting & Hot Shave',
            'image_url' => 'assets/images/team/barber-2.jpg',
            'sort_order' => 2
        ],
        [
            'name' => 'David Thorne',
            'slug' => 'david-thorne',
            'role' => 'Creative Fade Specialist',
            'bio' => 'Master of modern skin tapers, textured crops, grey camouflage, and avant-garde editorial styles.',
            'experience_years' => 8,
            'specialty' => 'Modern Fades & Hair Coloring',
            'image_url' => 'assets/images/team/barber-3.jpg',
            'sort_order' => 3
        ]
    ];

    $barberStmt = $pdo->prepare("INSERT INTO `barbers` (`name`, `slug`, `role`, `bio`, `experience_years`, `specialty`, `image_url`, `sort_order`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1) ON DUPLICATE KEY UPDATE `bio` = VALUES(`bio`), `specialty` = VALUES(`specialty`)");
    foreach ($barbers as $b) {
        $barberStmt->execute([
            $b['name'],
            $b['slug'],
            $b['role'],
            $b['bio'],
            $b['experience_years'],
            $b['specialty'],
            $b['image_url'],
            $b['sort_order']
        ]);
    }
    echo "      -> Seeded 3 Master Barbers.\n";

    // 4e. Business Hours
    $hours = [
        ['day_of_week' => 'monday', 'display_name' => 'Monday', 'open_time' => '09:00:00', 'close_time' => '20:00:00', 'is_closed' => 0],
        ['day_of_week' => 'tuesday', 'display_name' => 'Tuesday', 'open_time' => '09:00:00', 'close_time' => '20:00:00', 'is_closed' => 0],
        ['day_of_week' => 'wednesday', 'display_name' => 'Wednesday', 'open_time' => '09:00:00', 'close_time' => '20:00:00', 'is_closed' => 0],
        ['day_of_week' => 'thursday', 'display_name' => 'Thursday', 'open_time' => '09:00:00', 'close_time' => '20:00:00', 'is_closed' => 0],
        ['day_of_week' => 'friday', 'display_name' => 'Friday', 'open_time' => '09:00:00', 'close_time' => '20:00:00', 'is_closed' => 0],
        ['day_of_week' => 'saturday', 'display_name' => 'Saturday', 'open_time' => '09:00:00', 'close_time' => '18:00:00', 'is_closed' => 0],
        ['day_of_week' => 'sunday', 'display_name' => 'Sunday', 'open_time' => '10:00:00', 'close_time' => '16:00:00', 'is_closed' => 0],
    ];

    $hourStmt = $pdo->prepare("INSERT INTO `business_hours` (`day_of_week`, `display_name`, `open_time`, `close_time`, `is_closed`) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `open_time` = VALUES(`open_time`), `close_time` = VALUES(`close_time`), `is_closed` = VALUES(`is_closed`)");
    foreach ($hours as $h) {
        $hourStmt->execute([$h['day_of_week'], $h['display_name'], $h['open_time'], $h['close_time'], $h['is_closed']]);
    }
    echo "      -> Seeded 7-Day Business Hours Schedule.\n";

    // 4f. Gallery Portfolio
    $gallery = [
        ['title' => 'Executive Low Skin Fade', 'category' => 'Haircut', 'category_slug' => 'haircut', 'desc_text' => 'Seamless taper gradient with textured scissor matte finish.', 'image_url' => 'assets/images/gallery/gallery-1.jpg', 'thumbnail_url' => 'assets/images/gallery/gallery-1.jpg', 'sort_order' => 1],
        ['title' => 'Artisanal Beard Contour', 'category' => 'Beard Sculpt', 'category_slug' => 'beard', 'desc_text' => 'Sharp razor cheek lines with hot towel essential oil conditioning.', 'image_url' => 'assets/images/gallery/gallery-2.jpg', 'thumbnail_url' => 'assets/images/gallery/gallery-2.jpg', 'sort_order' => 2],
        ['title' => 'Traditional Hot Towel Shave', 'category' => 'Royal Shave', 'category_slug' => 'shave', 'desc_text' => 'Italian straight razor shave with badger brush lather.', 'image_url' => 'assets/images/gallery/gallery-3.jpg', 'thumbnail_url' => 'assets/images/gallery/gallery-3.jpg', 'sort_order' => 3],
        ['title' => 'Tailored Pompadour & Taper', 'category' => 'Styling', 'category_slug' => 'styling', 'desc_text' => 'Classic high-volume pompadour with subtle modern taper.', 'image_url' => 'assets/images/gallery/gallery-4.jpg', 'thumbnail_url' => 'assets/images/gallery/gallery-4.jpg', 'sort_order' => 4],
        ['title' => 'Bespoke Scissor Crop', 'category' => 'Haircut', 'category_slug' => 'haircut', 'desc_text' => 'Natural texture styling with low-shine clay pomade.', 'image_url' => 'assets/images/gallery/gallery-5.jpg', 'thumbnail_url' => 'assets/images/gallery/gallery-5.jpg', 'sort_order' => 5],
        ['title' => 'Full Executive Grooming', 'category' => 'Royal Shave', 'category_slug' => 'shave', 'desc_text' => 'Complete VIP head-to-beard grooming ritual.', 'image_url' => 'assets/images/gallery/gallery-6.jpg', 'thumbnail_url' => 'assets/images/gallery/gallery-6.jpg', 'sort_order' => 6],
    ];

    $galStmt = $pdo->prepare("INSERT INTO `gallery` (`title`, `category`, `category_slug`, `desc_text`, `image_url`, `thumbnail_url`, `sort_order`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, 1) ON DUPLICATE KEY UPDATE `desc_text` = VALUES(`desc_text`)");
    foreach ($gallery as $g) {
        $galStmt->execute([$g['title'], $g['category'], $g['category_slug'], $g['desc_text'], $g['image_url'], $g['thumbnail_url'], $g['sort_order']]);
    }
    echo "      -> Seeded 6 Gallery Portfolio Items.\n";

    // 4g. Testimonials
    $testimonials = [
        [
            'client_name' => 'James Sterling',
            'client_role' => 'Managing Director, Sterling Group',
            'client_avatar' => 'assets/images/testimonials/client-1.svg',
            'content' => 'The precision and hospitality at Kre8 is unlike anywhere else in Beverly Hills. Alexander sculpted the sharpest fade I have ever received. The complimentary bourbon and hot towels elevate every single visit.',
            'rating' => 5,
            'service_received' => 'Premium Grooming Experience'
        ],
        [
            'client_name' => 'Julian Vance',
            'client_role' => 'Architect & Creative Lead',
            'client_avatar' => 'assets/images/testimonials/client-2.svg',
            'content' => 'Marcus transformed my beard with absolute mastery. The razor cheek contours and organic cedarwood oils leave an incredible finish. This is true gentleman grooming.',
            'rating' => 5,
            'service_received' => 'Hair & Beard Combo'
        ],
        [
            'client_name' => 'Arthur Pendelton',
            'client_role' => 'Fine Watch Collector',
            'client_avatar' => 'assets/images/testimonials/client-3.svg',
            'content' => 'A sanctuary of craftsmanship. The royal hot shave took me back to classic Milanese barbershops. Impeccable attention to detail from the moment you step in.',
            'rating' => 5,
            'service_received' => 'Royal Shave Ritual'
        ]
    ];

    $testStmt = $pdo->prepare("INSERT INTO `testimonials` (`client_name`, `client_role`, `client_avatar`, `content`, `rating`, `service_received`, `is_active`, `is_featured`) VALUES (?, ?, ?, ?, ?, ?, 1, 1)");
    foreach ($testimonials as $t) {
        $testStmt->execute([$t['client_name'], $t['client_role'], $t['client_avatar'], $t['content'], $t['rating'], $t['service_received']]);
    }
    echo "      -> Seeded 3 Client Endorsements.\n";

    // 4h. Website Settings
    $settings = [
        ['setting_key' => 'app_name', 'setting_value' => 'Kre8 Barbershop', 'setting_group' => 'general', 'description' => 'Main brand name'],
        ['setting_key' => 'app_tagline', 'setting_value' => 'Crafting Confidence, One Cut at a Time', 'setting_group' => 'general', 'description' => 'Brand tagline'],
        ['setting_key' => 'contact_phone', 'setting_value' => '+1 (555) 349-8201', 'setting_group' => 'contact', 'description' => 'Concierge phone number'],
        ['setting_key' => 'contact_email', 'setting_value' => 'care@kre8barber.com', 'setting_group' => 'contact', 'description' => 'Customer service email'],
        ['setting_key' => 'contact_address', 'setting_value' => '742 Evergreen Terrace, Suite 100, Beverly Hills, CA 90210', 'setting_group' => 'contact', 'description' => 'Lounge address'],
        ['setting_key' => 'booking_notice', 'setting_value' => 'Please arrive 10 minutes prior to your chair reservation to enjoy a complimentary beverage.', 'setting_group' => 'booking', 'description' => 'Notice shown to booking clients'],
    ];

    $setStmt = $pdo->prepare("INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`, `description`) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
    foreach ($settings as $s) {
        $setStmt->execute([$s['setting_key'], $s['setting_value'], $s['setting_group'], $s['description']]);
    }
    echo "      -> Seeded Global Website Settings.\n";

    // 4i. Sample Customer & Initial Appointments
    $custStmt = $pdo->prepare("INSERT INTO `customers` (`first_name`, `last_name`, `email`, `phone`, `vip_status`) VALUES (?, ?, ?, ?, 'vip') ON DUPLICATE KEY UPDATE `phone` = VALUES(`phone`)");
    $custStmt->execute(['Charles', 'Montgomery', 'charles.m@example.com', '+15552349876']);
    $sampleCustomerId = $pdo->lastInsertId();

    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    $apptStmt = $pdo->prepare("INSERT INTO `appointments` (`customer_id`, `service_id`, `barber_id`, `first_name`, `last_name`, `email`, `phone`, `service_name`, `barber_name`, `appointment_date`, `appointment_time`, `status`, `message`) VALUES (?, 1, 1, 'Charles', 'Montgomery', 'charles.m@example.com', '+15552349876', 'Classic Haircut', 'Alexander Pierce', ?, '14:00:00', 'confirmed', 'Looking forward to the executive cut.')");
    $apptStmt->execute([$sampleCustomerId, $tomorrow]);
    echo "      -> Seeded Sample Confirmed Appointment for tomorrow at 14:00.\n\n";

    echo "[4/4] Complete! MySQL Database successfully migrated and populated.\n";
    echo "====================================================\n";
    echo "Admin Login URL: http://localhost:8000/admin/login.php\n";
    echo "Username: admin\n";
    echo "Password: Admin@Kre8Luxury2026!\n";
    echo "====================================================\n";

} catch (Exception $e) {
    echo "ERROR during database migration:\n" . $e->getMessage() . "\n";
    exit(1);
}
