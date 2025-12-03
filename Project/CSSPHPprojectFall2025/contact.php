<?php $pageTitle = "Contact"; include 'includes/header.php'; ?>
    <main class="contact-main">
        <section class="contact-container">
            <h2>Contact Us</h2>
            <form class="contact-form">
                <input type="text" name="name" placeholder="Your Name" required />
                <input type="email" name="email" placeholder="Your Email" required />
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send</button>
            </form>
        </section>
    </main>
<?php include 'includes/footer.php'; ?>