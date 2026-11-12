
<?php
require_once('files/functions.php');
require_once('files/header.php');
?>

<!-- Page Title -->
<div class="page-title-overlap bg-dark pt-4 pb-5">
    <div class="container pt-3">
        <h1 class="text-light text-center">Contact Us</h1>
        <p class="text-light text-center">
            Get in touch with Peak Performance Store
        </p>
    </div>
</div>

<!-- Contact Information -->
<div class="container py-5">

    <div class="text-center mb-5">
        <h2>We'd Love to Hear From You</h2>
        <p class="text-muted">
            Contact us for product enquiries, bicycle repairs,
            maintenance services and online orders.
        </p>
    </div>

    <div class="row">

        <!-- Phone Numbers -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <i class="ci-phone fs-1 text-primary mb-3"></i>
                <h4>Call Us</h4>

                <p class="mb-2">
                    <strong>Telephone:</strong>
                    <a href="tel:018 770 3122">
                        018 770 3122
                    </a>
                </p>

                <p>
                    <strong>Mobile:</strong>
                    <a href="tel:071 867 7555">
                        071 867 7555
                    </a>
                </p>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <i class="ci-mail fs-1 text-primary mb-3"></i>
                <h4>Email Us</h4>

                <p>
                    <a href="mailto:info@peakperformancestore.co.za">
                        info@peakperformancestore.co.za
                    </a>
                </p>
            </div>
        </div>

        <!-- Address -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <i class="ci-location fs-1 text-primary mb-3"></i>
                <h4>Visit Our Store</h4>

                <p>
                    59 President Street, Vista Building,
                    Potchefstroom, North West, South Africa.
                </p>
            </div>
        </div>

    </div>

    <!-- Business Enquiries -->
    <div class="row mt-4">
        <div class="col-lg-8 mx-auto">

            <div class="card border-0 shadow-sm p-4">
                <h3 class="text-center mb-4">Send Us an Enquiry</h3>

                <form action="#" method="post">

                    <div class="mb-3">
                        <label class="form-label">Your Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter your name"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter your email"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel"
                               name="phone"
                               class="form-control"
                               placeholder="Enter your phone number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Message</label>
                        <textarea name="message"
                                  class="form-control"
                                  rows="5"
                                  placeholder="How can we help you?"
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Send Message
                    </button>

                    <p class="text-muted small mt-3 mb-0">
                        Please note: the enquiry form is a visual
                        template and will need a backend to send messages.
                    </p>

                </form>
            </div>

        </div>
    </div>

</div>

<?php require_once('files/footer.php'); ?>
