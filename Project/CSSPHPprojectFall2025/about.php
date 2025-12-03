<?php
session_start();
$pageTitle = "About Us";
include 'includes/header.php';
?>

<main>
    <section class="about-section">
        <div class="about-image">
            <img src="bannerimage/about.jpg" alt="About Our Company">
        </div>
        <div class="about-text">
            <h2>About Our Company</h2>
            <p>
                We are a modern online storefront built to deliver quality products with simplicity and speed.
                We specialize in practical tools and everyday essentials.
                Our mission is to make shopping intuitive, secure, and enjoyable, whether you're browsing or buying.
            </p>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
