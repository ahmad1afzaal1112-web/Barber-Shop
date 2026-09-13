<?php
/**
 * Core Helper Functions & Data Providers
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../config/database.php';

$app_config = require __DIR__ . '/../config/app.php';

function get_app_config($key = null, $default = null) {
    global $app_config;
    if ($key === null) return $app_config;
    return $app_config[$key] ?? $default;
}

/**
 * Fetch All Active Services
 */
function get_services() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            $services = $stmt->fetchAll();
            if (!empty($services)) return $services;
        } catch (\Throwable $e) {
            error_log("Services fetch error: " . $e->getMessage());
        }
    }

    // Default High-Fidelity Dataset — 8 Signature Services
    return [
        [
            'id' => 1,
            'title' => 'Classic Haircut',
            'slug' => 'classic-haircut',
            'price' => 35.00,
            'duration' => '45 Mins',
            'description' => 'Tailored precision scissor and clipper cut crafted to compliment your natural head shape and personal aesthetic.',
            'icon_name' => 'scissors',
            'badge' => 'SIGNATURE',
            'features' => ['Consultation & scissor work', 'Clean taper & neck line', 'Invigorating hair wash', 'Matte clay styling finish']
        ],
        [
            'id' => 2,
            'title' => 'Skin Fade',
            'slug' => 'skin-fade',
            'price' => 40.00,
            'duration' => '50 Mins',
            'description' => 'Seamless gradient fade down to skin using foil shavers and precision clippers, balanced with textured scissor top work.',
            'icon_name' => 'scissors',
            'badge' => 'POPULAR',
            'features' => ['Zero skin taper blend', 'Foil shaver finish', 'Crisp hairline contour', 'Cool tonic scalp rinse']
        ],
        [
            'id' => 3,
            'title' => 'Beard Styling',
            'slug' => 'beard-styling',
            'price' => 28.00,
            'duration' => '30 Mins',
            'description' => 'Sculpted beard shaping, sharp straight razor cheek lines, hot towel steam, and nourishing organic botanical oils.',
            'icon_name' => 'razor',
            'badge' => 'TRENDING',
            'features' => ['Beard length sculpting', 'Razor cheek & neck line', 'Hot eucalyptus towel', 'Organic cedarwood oil']
        ],
        [
            'id' => 4,
            'title' => 'Hair & Beard Combo',
            'slug' => 'hair-beard-combo',
            'price' => 58.00,
            'duration' => '65 Mins',
            'description' => 'Complete transformation combining our bespoke precision haircut with tailored beard sculpting and hot towel ritual.',
            'icon_name' => 'crown',
            'badge' => 'BEST VALUE',
            'features' => ['Full precision haircut', 'Artisanal beard sculpt', 'Double hot steam towel', 'Styling & beard balm']
        ],
        [
            'id' => 5,
            'title' => 'Royal Shave',
            'slug' => 'royal-shave',
            'price' => 45.00,
            'duration' => '45 Mins',
            'description' => 'Authentic straight razor shave with rich badger-hair lather, dual hot herbal towels, and soothing cold astringent finish.',
            'icon_name' => 'brush',
            'badge' => 'LUXURY',
            'features' => ['Pre-shave essential oils', 'Traditional straight razor', 'Two hot herbal towels', 'Cold astringent balm']
        ],
        [
            'id' => 6,
            'title' => 'Kids Haircut',
            'slug' => 'kids-haircut',
            'price' => 26.00,
            'duration' => '30 Mins',
            'description' => 'Gentle, patient, and modern cuts for younger gentlemen aged 12 and under, styled with light kid-safe water-based cream.',
            'icon_name' => 'scissors',
            'badge' => null,
            'features' => ['Patient scissor work', 'Clean neckline trim', 'Gentle styling cream', 'Lollipop & beverage']
        ],
        [
            'id' => 7,
            'title' => 'Hair Styling',
            'slug' => 'hair-styling',
            'price' => 30.00,
            'duration' => '35 Mins',
            'description' => 'Botanical shampoo wash, professional round-brush blow dry, and bespoke product layering for formal events or nights out.',
            'icon_name' => 'comb',
            'badge' => null,
            'features' => ['Deep cleansing wash', 'Volumizing blow-dry', 'Bespoke pomade styling', 'Style longevity lock']
        ],
        [
            'id' => 8,
            'title' => 'Premium Grooming',
            'slug' => 'premium-grooming',
            'price' => 95.00,
            'duration' => '90 Mins',
            'description' => 'The complete gentleman ritual: bespoke haircut, royal straight shave, herbal facial exfoliation, and lounge refreshments.',
            'icon_name' => 'crown',
            'badge' => 'VIP EXPERIENCE',
            'features' => ['Master bespoke haircut', 'Full straight razor shave', 'Herbal steam facial mask', 'Complimentary single-malt']
        ]
    ];
}

/**
 * Fetch Team Members
 */
function get_team_members() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM team_members WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            $team = $stmt->fetchAll();
            if (!empty($team)) return $team;
        } catch (\Throwable $e) {
            error_log("Team fetch error: " . $e->getMessage());
        }
    }

    return [
        [
            'id' => 1,
            'name' => 'Alexander Pierce',
            'role' => 'Founder & Master Stylist',
            'bio' => 'Over 14 years mastering precision scissor work, classic Italian razor rituals, and high-end menswear grooming.',
            'experience_years' => 14,
            'specialty' => 'Classic Scissor Cuts & Fades',
            'image_url' => 'assets/images/team/barber-1.jpg',
            'social' => ['instagram' => 'https://instagram.com', 'facebook' => 'https://facebook.com', 'twitter' => 'https://twitter.com']
        ],
        [
            'id' => 2,
            'name' => 'Marcus Vance',
            'role' => 'Senior Beard Artisan',
            'bio' => 'Award-winning beard stylist specializing in sculptured beard fades, sharp contouring, and hot towel skin rejuvenation.',
            'experience_years' => 9,
            'specialty' => 'Beard Sculpting & Hot Shave',
            'image_url' => 'assets/images/team/barber-2.jpg',
            'social' => ['instagram' => 'https://instagram.com', 'facebook' => 'https://facebook.com', 'twitter' => 'https://twitter.com']
        ],
        [
            'id' => 3,
            'name' => 'David Thorne',
            'role' => 'Creative Hair Director',
            'bio' => 'Expert in modern textured tapers, skin fades, executive scissor styling, and editorial hair aesthetics.',
            'experience_years' => 8,
            'specialty' => 'Modern Fades & Hair Coloring',
            'image_url' => 'assets/images/team/barber-3.jpg',
            'social' => ['instagram' => 'https://instagram.com', 'facebook' => 'https://facebook.com', 'twitter' => 'https://twitter.com']
        ]
    ];
}

/**
 * Fetch Testimonials
 */
function get_testimonials() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY id ASC");
            $reviews = $stmt->fetchAll();
            if (!empty($reviews)) return $reviews;
        } catch (\Throwable $e) {
            error_log("Testimonials fetch error: " . $e->getMessage());
        }
    }

    return [
        [
            'id' => 1,
            'client_name' => 'James Sterling',
            'client_role' => 'Managing Director, Sterling Group',
            'client_avatar' => 'assets/images/testimonials/client-1.svg',
            'content' => 'The attention to detail at Kre8 is unmatched anywhere in the city. The royal shave is a masterclass in relaxation and precision. I will never trust my grooming to anyone else.',
            'rating' => 5,
            'service_received' => 'The Royal VIP Package'
        ],
        [
            'id' => 2,
            'client_name' => 'Robert Chen',
            'client_role' => 'Principal Architect, Studio Chen',
            'client_avatar' => 'assets/images/testimonials/client-2.svg',
            'content' => 'Step inside and you immediately feel the refined, luxurious ambiance. Marcus sculpted my beard with surgical precision. The complimentary single-malt and hot towels are top tier.',
            'rating' => 5,
            'service_received' => 'Signature Beard Sculpting'
        ],
        [
            'id' => 3,
            'client_name' => 'Michael Anderson',
            'client_role' => 'Creative Producer & Director',
            'client_avatar' => 'assets/images/testimonials/client-3.svg',
            'content' => 'Flawless fade, incredible hospitality, and true master craftsmen who genuinely understand bone structure and hair textures. Book in advance—their reputation is well deserved.',
            'rating' => 5,
            'service_received' => 'Classic Haircut & Scalp Wash'
        ],
        [
            'id' => 4,
            'client_name' => 'Harrison Blake',
            'client_role' => 'Venture Partner, Blake Capital',
            'client_avatar' => 'assets/images/testimonials/client-1.svg',
            'content' => 'The hot towel ritual and straight razor shave are like hitting a master reset button on a stressful week. The caliber of service and privacy in the lounge is unrivaled.',
            'rating' => 5,
            'service_received' => 'Traditional Royal Shave'
        ],
        [
            'id' => 5,
            'client_name' => 'Julian Vance',
            'client_role' => 'Fashion Editor & Stylist',
            'client_avatar' => 'assets/images/testimonials/client-2.svg',
            'content' => 'David listened to exactly what I needed for my editorial look and executed the cleanest skin fade I’ve ever had. Truly the gold standard of modern menswear barbering.',
            'rating' => 5,
            'service_received' => 'Skin Fade & Beard Styling'
        ]
    ];
}

/**
 * Fetch Products
 */
function get_products() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1 ORDER BY id ASC");
            $products = $stmt->fetchAll();
            if (!empty($products)) return $products;
        } catch (\Throwable $e) {
            error_log("Products fetch error: " . $e->getMessage());
        }
    }

    return [
        [
            'id' => 1,
            'name' => 'Matte Finish Clay Pomade',
            'category' => 'Styling',
            'price' => 24.00,
            'old_price' => 28.00,
            'rating' => 4.9,
            'reviews_count' => 38,
            'image_url' => 'assets/images/products/product-1.svg',
            'badge' => 'BESTSELLER',
            'description' => 'High hold with a zero-shine matte finish. Infused with natural bentonite clay and beeswax.'
        ],
        [
            'id' => 2,
            'name' => 'Organic Cedarwood Beard Oil',
            'category' => 'Beard Care',
            'price' => 22.00,
            'old_price' => null,
            'rating' => 5.0,
            'reviews_count' => 52,
            'image_url' => 'assets/images/products/product-2.svg',
            'badge' => 'ORGANIC',
            'description' => 'Cold-pressed Moroccan argan oil blended with Atlas cedarwood, jojoba, and vitamin E.'
        ],
        [
            'id' => 3,
            'name' => 'Artisanal Sandalwood Shave Cream',
            'category' => 'Shaving',
            'price' => 26.00,
            'old_price' => 30.00,
            'rating' => 4.8,
            'reviews_count' => 19,
            'image_url' => 'assets/images/products/product-3.svg',
            'badge' => 'HOT',
            'description' => 'Rich conditioning lather that softens the coarsest whiskers and shields skin from irritation.'
        ],
        [
            'id' => 4,
            'name' => 'Damascus Steel Straight Razor',
            'category' => 'Accessories',
            'price' => 75.00,
            'old_price' => 89.00,
            'rating' => 5.0,
            'reviews_count' => 44,
            'image_url' => 'assets/images/products/product-4.svg',
            'badge' => 'PREMIUM',
            'description' => 'Hand-forged Japanese steel blade with an ebony wood handle for supreme balance and control.'
        ]
    ];
}

/**
 * Fetch Gallery Items
 */
function get_gallery_items() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM gallery WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            $gallery = $stmt->fetchAll();
            if (!empty($gallery)) return $gallery;
        } catch (\Throwable $e) {
            error_log("Gallery fetch error: " . $e->getMessage());
        }
    }

    return [
        [
            'id' => 1,
            'title' => 'Executive Low Skin Fade',
            'category' => 'Haircut',
            'category_slug' => 'haircut',
            'image_url' => 'assets/images/gallery/gallery-1.jpg',
            'desc' => 'Precision scissor-over-comb blend with foil shaver skin fade.'
        ],
        [
            'id' => 2,
            'title' => 'Sculpted Beard & Razor Contour',
            'category' => 'Beard',
            'category_slug' => 'beard',
            'image_url' => 'assets/images/gallery/gallery-2.jpg',
            'desc' => 'Sharp cheek line contouring with botanical beard treatment.'
        ],
        [
            'id' => 3,
            'title' => 'Hot Towel Straight Razor Shave',
            'category' => 'Shave',
            'category_slug' => 'shave',
            'image_url' => 'assets/images/gallery/gallery-3.jpg',
            'desc' => 'Classic luxury shaving ritual with dual steaming herbal towels.'
        ],
        [
            'id' => 4,
            'title' => 'Textured Modern Pompadour',
            'category' => 'Styling',
            'category_slug' => 'styling',
            'image_url' => 'assets/images/gallery/gallery-4.jpg',
            'desc' => 'Volume blow-dry styling locked with matte clay finish.'
        ],
        [
            'id' => 5,
            'title' => 'Classic Side Part & Taper',
            'category' => 'Haircut',
            'category_slug' => 'haircut',
            'image_url' => 'assets/images/gallery/gallery-5.jpg',
            'desc' => 'Timeless gentleman aesthetic with natural scissor-blended taper.'
        ],
        [
            'id' => 6,
            'title' => 'Full Beard Trim & Mustache Wax',
            'category' => 'Beard',
            'category_slug' => 'beard',
            'image_url' => 'assets/images/gallery/gallery-6.jpg',
            'desc' => 'Hand-trimmed beard shape with organic beeswax handlebar styling.'
        ]
    ];
}

/**
 * Fetch Pricing Packages & Menu
 */
function get_pricing_packages() {
    return [
        'tiers' => [
            [
                'id' => 1,
                'name' => 'Essential Cut',
                'badge' => 'STANDARD',
                'is_popular' => false,
                'price' => 45.00,
                'period' => 'Per Visit',
                'description' => 'Perfect for the modern gentleman needing consistent, sharp maintenance cuts.',
                'features' => [
                    'Detailed head shape consultation',
                    'Precision scissors or clipper fade',
                    'Invigorating scalp wash & conditioner',
                    'Neck razor cleanup with hot lather',
                    'Finishing product & blow-dry style'
                ],
                'cta_text' => 'Book Essential'
            ],
            [
                'id' => 2,
                'name' => 'Signature Grooming',
                'badge' => 'MOST POPULAR',
                'is_popular' => true,
                'price' => 75.00,
                'period' => 'Per Visit',
                'description' => 'Our highly recommended flagship pairing: bespoke haircut with artisanal beard sculpting.',
                'features' => [
                    'Everything in Essential Cut',
                    'Custom beard sculpting & razor edge',
                    'Dual steaming eucalyptus hot towels',
                    'Cedarwood & argan oil treatment',
                    'Cold astringent pore closure',
                    'Complimentary lounge beverage'
                ],
                'cta_text' => 'Book Signature'
            ],
            [
                'id' => 3,
                'name' => 'Royal VIP Experience',
                'badge' => 'ULTRA LUXURY',
                'is_popular' => false,
                'price' => 120.00,
                'period' => 'Per Visit',
                'description' => 'The ultimate 90-minute bespoke pampering ritual for distinguished gentlemen.',
                'features' => [
                    'Master stylist tailored haircut',
                    'Old-world straight razor hot shave',
                    'Exfoliating herbal steam facial mask',
                    '15-minute shoulder & neck acupressure',
                    'Full-size styling pomade to take home',
                    'Top-shelf single-malt whiskey pour'
                ],
                'cta_text' => 'Book Royal VIP'
            ]
        ],
        'menu' => [
            ['title' => 'Classic Scissor Haircut', 'price' => 35.00, 'desc' => 'Handcrafted scissor taper with warm neck lather razor cleanup'],
            ['title' => 'Low / Mid / High Skin Fade', 'price' => 40.00, 'desc' => 'Zero-fade foil finish with crisp temple and ear outlines'],
            ['title' => 'Signature Beard Sculpt & Line', 'price' => 28.00, 'desc' => 'Length tapering, cheekbone line shaping & hot towel steam'],
            ['title' => 'Traditional Straight Razor Shave', 'price' => 45.00, 'desc' => 'Dual hot towel prep, warm badger lather, and soothing balm'],
            ['title' => 'Executive Hair & Beard Combo', 'price' => 58.00, 'desc' => 'Complete hair styling paired with luxury beard rejuvenation'],
            ['title' => 'Grey Blending & Color Camo', 'price' => 50.00, 'desc' => 'Natural subtle demi-permanent grey reduction treatment']
        ]
    ];
}

/**
 * Fetch FAQs
 */
function get_faqs() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM faqs WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
            $faqs = $stmt->fetchAll();
            if (!empty($faqs)) return $faqs;
        } catch (\Throwable $e) {
            error_log("FAQ fetch error: " . $e->getMessage());
        }
    }

    return [
        [
            'id' => 1,
            'question' => 'Do I need to book an appointment in advance?',
            'answer' => 'While walk-ins are always warmly welcomed based on chair availability, we strongly recommend reserving your slot online or via telephone to guarantee your preferred master barber and time without waiting.'
        ],
        [
            'id' => 2,
            'question' => 'What premium grooming products do you use in services?',
            'answer' => 'We exclusively curate and apply certified organic, paraben-free essentials, including Italian shaving soaps, British botanical styling clays, and cold-pressed cedarwood beard oils that nourish both hair and skin.'
        ],
        [
            'id' => 3,
            'question' => 'How early should I arrive for my appointment?',
            'answer' => 'We recommend arriving 10-15 minutes prior to your booking. This allows you to relax in our leather lounge, enjoy a complimentary beverage (espresso, craft beer, or single-malt whiskey), and consult with your stylist.'
        ],
        [
            'id' => 4,
            'question' => 'Can I request a specific barber for my visit?',
            'answer' => 'Yes, absolutely. Our online booking portal and concierge service let you choose your favorite master stylist when scheduling your appointment.'
        ],
        [
            'id' => 5,
            'question' => 'What is your cancellation and rescheduling policy?',
            'answer' => 'We understand schedules change. We kindly request at least 4 hours advance notice for cancellations or rescheduling so we can offer the appointment to gentlemen on our waitlist.'
        ]
    ];
}

/**
 * Fetch Blog Posts
 */
function get_blog_posts() {
    $pdo = get_db_connection();
    if ($pdo) {
        try {
            $stmt = $pdo->query("SELECT * FROM blog_posts WHERE is_active = 1 ORDER BY published_date DESC LIMIT 3");
            $posts = $stmt->fetchAll();
            if (!empty($posts)) return $posts;
        } catch (\Throwable $e) {
            error_log("Blog fetch error: " . $e->getMessage());
        }
    }

    return [
        [
            'id' => 1,
            'title' => 'The Art of the Classic Straight Razor Shave',
            'slug' => 'art-of-classic-straight-razor-shave',
            'excerpt' => 'Discover why the century-old straight razor ritual remains the ultimate indulgence in men’s grooming.',
            'published_date' => '2026-08-15',
            'category' => 'Grooming Guide',
            'author' => 'Alexander Pierce',
            'image_url' => 'assets/images/blog/blog-1.svg',
            'read_time' => '4 min read'
        ],
        [
            'id' => 2,
            'title' => 'How to Maintain a Sharp Beard Between Visits',
            'slug' => 'how-to-maintain-sharp-beard',
            'excerpt' => 'Essential daily hydration secrets, correct brushing techniques, and trimming tricks to keep your beard immaculate.',
            'published_date' => '2026-08-28',
            'category' => 'Beard Care',
            'author' => 'Marcus Vance',
            'image_url' => 'assets/images/blog/blog-2.svg',
            'read_time' => '5 min read'
        ],
        [
            'id' => 3,
            'title' => 'Standout Men’s Hairstyles Redefining Modern Luxury',
            'slug' => 'trending-mens-hairstyles',
            'excerpt' => 'From subtle scissor tapers to textured pompadours, explore the premier cuts defining masculine sophistication.',
            'published_date' => '2026-09-05',
            'category' => 'Style Trends',
            'author' => 'David Thorne',
            'image_url' => 'assets/images/blog/blog-3.svg',
            'read_time' => '6 min read'
        ]
    ];
}

/**
 * Render Vector SVG Icons for Barbershop Theme
 */
function render_svg_icon($name, $class = 'icon-svg') {
    $icons = [
        'scissors' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/></svg>',
        'razor' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 18h16M4 14h16M6 10h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2z"/><path d="M12 18v3M8 21h8"/></svg>',
        'brush' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m9.06 11.9 8.07-8.06a2.85 2.85 0 1 1 4.03 4.03l-8.06 8.08"/><path d="M7.07 14.94c-1.66 0-3 1.34-3 3 0 1.5 2 3.5 2.5 4 .5.5 1 .5 1.5 0s2.5-2.5 2.5-4c0-1.66-1.34-3-3-3z"/></svg>',
        'comb' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5h18v6H3z"/><line x1="6" y1="11" x2="6" y2="19"/><line x1="9" y1="11" x2="9" y2="19"/><line x1="12" y1="11" x2="12" y2="19"/><line x1="15" y1="11" x2="15" y2="19"/><line x1="18" y1="11" x2="18" y2="19"/></svg>',
        'crown' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14v1H5z"/></svg>',
        'star' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'phone' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'mail' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'map-pin' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        'clock' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'calendar' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'check' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
        'play' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>',
        'arrow-right' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'quote' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>',
        'instagram' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'facebook' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
        'twitter' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
        'youtube' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>',
        'cart' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
        'chevron-down' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>',
        'chevron-left' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>',
        'chevron-right' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>',
        'close' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'search' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        'sparkles' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"/></svg>',
        'award' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
        'heart' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
        'user' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'plus' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
        'minus' => '<svg class="' . htmlspecialchars($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>'
    ];

    return $icons[$name] ?? '';
}

function format_price($price) {
    return '$' . number_format((float)$price, 2);
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
