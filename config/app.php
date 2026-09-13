<?php
/**
 * Application Global Configuration
 * Kre8 Luxury Barbershop
 */

return [
    'app_name' => 'Kre8 Barbershop',
    'app_tagline' => 'Crafting Confidence, One Cut at a Time',
    'app_url' => 'http://localhost:8000',
    'phone' => '+1 (555) 349-8201',
    'phone_clean' => '+15553498201',
    'email' => 'care@kre8barber.com',
    'address' => '742 Evergreen Terrace, Suite 100, Beverly Hills, CA 90210',
    'hours' => [
        'Mon - Fri' => '09:00 AM - 08:00 PM',
        'Saturday'  => '09:00 AM - 06:00 PM',
        'Sunday'    => '10:00 AM - 04:00 PM'
    ],
    'social' => [
        'facebook' => 'https://facebook.com',
        'instagram' => 'https://instagram.com',
        'twitter' => 'https://twitter.com',
        'youtube' => 'https://youtube.com',
        'tiktok' => 'https://tiktok.com'
    ],
    'stats' => [
        'rating' => '4.9',
        'reviews_count' => '2.5k+',
        'experience_years' => '15+',
        'clients_served' => '25k+',
        'master_barbers' => '12+'
    ],
    'nav_menu' => [
        ['label' => 'Home', 'url' => '#hero', 'active' => true, 'has_dropdown' => true],
        ['label' => 'About Us', 'url' => '#about', 'active' => false, 'has_dropdown' => false],
        ['label' => 'Services', 'url' => '#services', 'active' => false, 'has_dropdown' => false],
        ['label' => 'Shop', 'url' => '#products', 'active' => false, 'has_dropdown' => true],
        ['label' => 'Blogs', 'url' => '#blog', 'active' => false, 'has_dropdown' => true],
        ['label' => 'Pages', 'url' => '#gallery', 'active' => false, 'has_dropdown' => true],
        ['label' => 'Contact Us', 'url' => '#appointment', 'active' => false, 'has_dropdown' => false]
    ]
];
