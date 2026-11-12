
<?php
require_once('files/functions.php');

// Database connection
$host = 'localhost';
$dbname = 'e-peakperformance';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die('Database connection failed. Please check your database settings.');
}

$message = '';
$messageType = '';

$name = '';
$email = '';
$phone = '';
$repair_date = '';
$repair_time = '';
$description = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $repair_date = $_POST['repair_date'] ?? '';
    $repair_time = $_POST['repair_time'] ?? '';
    $description = trim($_POST['description'] ?? '');

    $errors = [];

    if ($name === '') {
        $errors[] = 'Please enter your full name.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($phone === '' || !ctype_digit($phone)) {
        $errors[] = 'Please enter a phone number using digits only.';
    } elseif (strlen($phone) > 11) {
        $errors[] = 'The phone number cannot exceed 11 digits.';
    }

    if ($repair_date === '') {
        $errors[] = 'Please select a repair date.';
    } elseif ($repair_date < date('Y-m-d')) {
        $errors[] = 'Please select today or a future date.';
    }

    if ($repair_time === '') {
        $errors[] = 'Please select a repair time.';
    }

    if ($description === '') {
        $errors[] = 'Please describe the repair problem.';
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO repair_booking
                    (name, email, phone, repair_date,
                     repair_time, description, status)
                    VALUES
                    (:name, :email, :phone, :repair_date,
                     :repair_time, :description, :status)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':repair_date' => $repair_date,
                ':repair_time' => $repair_time,
                ':description' => $description,
                ':status' => 'Pending'
            ]);

            $message = 'Your repair booking has been submitted successfully!';
            $messageType = 'success';

            $name = '';
            $email = '';
            $phone = '';
            $repair_date = '';
            $repair_time = '';
            $description = '';

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $message = 'Unable to save your booking. Please check your details and try again.';
            $messageType = 'danger';
        }

    } else {
        $message = implode(' ', $errors);
        $messageType = 'danger';
    }
}

require_once('files/header.php');
?>

<!-- Page Title -->
<div class="page-title-overlap bg-dark pt-4 pb-5">
    <div class="container pt-3">
        <h1 class="text-light text-center">Repair Booking</h1>
        <p class="text-light text-center">
            Book a repair with Peak Performance Store
        </p>
    </div>
</div>

<!-- Repair Booking Form -->
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card border-0 shadow-lg mt-n4">
                <div class="card-body p-4 p-md-5">

                    <h3 class="h5 mb-2">Book Your Repair</h3>

                    <p class="text-muted mb-4">
                        Complete the form below and we will review your request.
                    </p>

                    <?php if ($message !== ''): ?>
                        <div class="alert alert-<?= htmlspecialchars($messageType) ?>"
                             role="alert">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form id="repairForm"
                          method="POST"
                          action="repair-booking.php">

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Full Name
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   maxlength="255"
                                   value="<?= htmlspecialchars($name) ?>"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email Address
                                </label>
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       name="email"
                                       maxlength="255"
                                       value="<?= htmlspecialchars($email) ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number
                                </label>
                                <input type="tel"
                                       class="form-control"
                                       id="phone"
                                       name="phone"
                                       inputmode="numeric"
                                       pattern="[0-9]{1,11}"
                                       maxlength="11"
                                       value="<?= htmlspecialchars($phone) ?>"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="repair_date" class="form-label">
                                    Preferred Date
                                </label>
                                <input type="date"
                                       class="form-control"
                                       id="repair_date"
                                       name="repair_date"
                                       value="<?= htmlspecialchars($repair_date) ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="repair_time" class="form-label">
                                    Preferred Time
                                </label>
                                <input type="time"
                                       class="form-control"
                                       id="repair_time"
                                       name="repair_time"
                                       value="<?= htmlspecialchars($repair_time) ?>"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">
                                Describe the Repair Problem
                            </label>
                            <textarea class="form-control"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      maxlength="2000"
                                      placeholder="Describe what needs repairing..."
                                      required><?= htmlspecialchars($description) ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Submit Repair Booking
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('repairForm');
    const dateInput = document.getElementById('repair_date');
    const description = document.getElementById('description');

    const today = new Date();
    today.setMinutes(today.getMinutes() - today.getTimezoneOffset());

    dateInput.min = today.toISOString().split('T')[0];

    form.addEventListener('submit', function (event) {
        if (dateInput.value < dateInput.min) {
            event.preventDefault();
            alert('Please select today or a future repair date.');
        } else if (description.value.trim().length < 10) {
            event.preventDefault();
            alert('Please describe the repair problem in at least 10 characters.');
            description.focus();
        }
    });
});
</script>

<?php require_once('files/footer.php'); ?>
