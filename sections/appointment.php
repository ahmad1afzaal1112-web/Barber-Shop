<?php
/**
 * Appointment Booking Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$services = get_services();
$team = get_team_members();
$config = get_app_config();
?>
<section class="section appointment-section" id="appointment">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">APPOINTMENT</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('calendar'); ?>
                <span>VIP Reservation</span>
            </div>
            <h2 class="section-title">
                Reserve Your <span class="text-gold-gradient">Grooming Session</span>
            </h2>
            <p class="section-desc">
                Select your preferred service, master barber, and convenient time slot. Our concierge will ensure your chair is prepared with precision.
            </p>
        </div>

        <div class="appointment-grid">
            <!-- Left Contact Info Cards -->
            <div class="appointment-info-col reveal reveal-left">
                <!-- Phone Card -->
                <div class="contact-card-box">
                    <div class="contact-card-icon">
                        <?php echo render_svg_icon('phone'); ?>
                    </div>
                    <div>
                        <div class="contact-card-label">Direct Concierge Hotline</div>
                        <a href="tel:<?php echo htmlspecialchars($config['phone_clean']); ?>" class="contact-card-value">
                            <?php echo htmlspecialchars($config['phone']); ?>
                        </a>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="contact-card-box">
                    <div class="contact-card-icon">
                        <?php echo render_svg_icon('mail'); ?>
                    </div>
                    <div>
                        <div class="contact-card-label">Email Inquiries</div>
                        <a href="mailto:<?php echo htmlspecialchars($config['email']); ?>" class="contact-card-value">
                            <?php echo htmlspecialchars($config['email']); ?>
                        </a>
                    </div>
                </div>

                <!-- Location Card -->
                <div class="contact-card-box">
                    <div class="contact-card-icon">
                        <?php echo render_svg_icon('map-pin'); ?>
                    </div>
                    <div>
                        <div class="contact-card-label">Beverly Hills Lounge</div>
                        <div class="contact-card-value" style="font-size: 0.95rem; font-weight: normal; color: var(--color-text-secondary);">
                            <?php echo htmlspecialchars($config['address']); ?>
                        </div>
                    </div>
                </div>

                <!-- Hours Card -->
                <div class="contact-card-box">
                    <div class="contact-card-icon">
                        <?php echo render_svg_icon('clock'); ?>
                    </div>
                    <div>
                        <div class="contact-card-label">Lounge Operating Hours</div>
                        <div class="contact-card-value" style="font-size: 0.95rem; font-weight: normal; color: var(--color-text-secondary);">
                            Mon - Fri: 9:00 AM - 8:00 PM<br>
                            Sat - Sun: 9:00 AM - 6:00 PM
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Booking Form Card -->
            <div class="appointment-form-col reveal reveal-right delay-1">
                <div class="booking-form-card">
                    <form id="appointment-form" action="api/submit-appointment.php" method="POST" novalidate>
                        <!-- Name Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name <span class="req">*</span></label>
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Alexander" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name <span class="req">*</span></label>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Pierce" required>
                            </div>
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address <span class="req">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="alexander@example.com" required>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number <span class="req">*</span></label>
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="+1 (555) 019-2834" required>
                            </div>
                        </div>

                        <!-- Service & Barber Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="service" class="form-label">Selected Service <span class="req">*</span></label>
                                <select id="service" name="service" class="form-control" required>
                                    <?php foreach ($services as $srv): ?>
                                        <option value="<?php echo htmlspecialchars($srv['title']); ?>">
                                            <?php echo htmlspecialchars($srv['title']); ?> (<?php echo format_price($srv['price']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="barber" class="form-label">Preferred Stylist</label>
                                <select id="barber" name="barber" class="form-control">
                                    <option value="Any Available Master">Any Available Master</option>
                                    <?php foreach ($team as $member): ?>
                                        <option value="<?php echo htmlspecialchars($member['name']); ?>">
                                            <?php echo htmlspecialchars($member['name']); ?> (<?php echo htmlspecialchars($member['role']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Date & Time Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="appointment_date" class="form-label">Preferred Date <span class="req">*</span></label>
                                <input type="date" id="appointment_date" name="appointment_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="appointment_time" class="form-label">Preferred Time Slot <span class="req">*</span></label>
                                <select id="appointment_time" name="appointment_time" class="form-control" required>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="10:00 AM" selected>10:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="01:00 PM">01:00 PM</option>
                                    <option value="02:30 PM">02:30 PM</option>
                                    <option value="04:00 PM">04:00 PM</option>
                                    <option value="05:30 PM">05:30 PM</option>
                                    <option value="07:00 PM">07:00 PM</option>
                                </select>
                            </div>
                        </div>

                        <!-- Special Message -->
                        <div class="form-group">
                            <label for="message" class="form-label">Special Requests / Preferences</label>
                            <textarea id="message" name="message" class="form-control" placeholder="E.g., Beverage preferences, specific styling reference or skin sensitivities..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg" id="submit-booking-btn" style="width: 100%;">
                            <span id="booking-btn-text">Confirm VIP Appointment</span>
                            <?php echo render_svg_icon('arrow-right'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
