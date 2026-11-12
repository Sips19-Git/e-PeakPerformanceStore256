
<?php
require_once('files/functions.php');

protected_area();

// ---- IMPORTANT: your PK is user_id, not id ----
$user_id = (int) $_SESSION['user']['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ============ UPDATE PROFILE INFO ============
    if (($_POST['action'] ?? '') === 'update_info') {

        if (validate([
            'first_name'   => ['required'],
            'last_name'    => ['required'],
            'email'        => ['required', 'email'],
            'phone_number' => ['required'],
            'username'     => ['required'],
        ])) {
            global $conn;

            $email    = $conn->real_escape_string($_POST['email']);
            $username = $conn->real_escape_string($_POST['username']);

            // Email must not belong to ANOTHER user
            $email_check = $conn->query(
                "SELECT user_id FROM users WHERE email = '$email' AND user_id != $user_id"
            );

            // Username must not belong to ANOTHER user
            $user_check = $conn->query(
                "SELECT user_id FROM users WHERE username = '$username' AND user_id != $user_id"
            );

            if (!$email_check || !$user_check) {
                alert('danger', 'Unable to check your email or username. Please try again.');
            } elseif ($email_check->num_rows > 0) {
                alert('danger', 'That email is already in use by another account.');
            } elseif ($user_check->num_rows > 0) {
                alert('danger', 'That username is already taken.');
            } else {

                db_update('users', [
                    'first_name'   => $_POST['first_name'],
                    'last_name'    => $_POST['last_name'],
                    'username'     => $_POST['username'],
                    'email'        => $_POST['email'],
                    'phone_number' => $_POST['phone_number'],
                ], "user_id = $user_id");

                // Refresh session with new values
                $result = $conn->query(
                    "SELECT * FROM users WHERE user_id = $user_id"
                );

                if ($result && $result->num_rows > 0) {
                    $_SESSION['user'] = $result->fetch_assoc();
                    alert('success', 'Profile updated successfully.');
                } else {
                    alert('danger', 'Profile saved, but the updated information could not be loaded.');
                }
            }

            unset($_SESSION['form']);
            header('Location: account-profile.php');
            exit;
        }

        header('Location: account-profile.php');
        exit;
    }

    // ============ CHANGE PASSWORD ============
    if (($_POST['action'] ?? '') === 'change_password') {

        if (validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:6'],
            'confirm_password' => ['required', 'match:new_password'],
        ])) {

            if (!password_verify(
                $_POST['current_password'],
                $_SESSION['user']['password']
            )) {
                alert('danger', 'Current password is incorrect.');
            } else {

                $new_hash = password_hash(
                    $_POST['new_password'],
                    PASSWORD_DEFAULT
                );

                db_update('users', [
                    'password' => $new_hash
                ], "user_id = $user_id");

                $_SESSION['user']['password'] = $new_hash;

                alert('success', 'Password changed successfully.');
            }

            unset($_SESSION['form']);
            header('Location: account-profile.php');
            exit;
        }

        header('Location: account-profile.php');
        exit;
    }
}

$user = $_SESSION['user'];

// Include the header only AFTER all redirects and PHP processing
require_once('files/header.php');
?>

<!-- Page content -->
<main class="page-wrapper">

    <?php if (isset($_SESSION['alert'])): ?>
        <div class="container pt-4">
            <div class="alert alert-<?= $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($_SESSION['alert']['message']) ?>
            </div>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <div class="container py-5">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="list-group">

                    <a class="list-group-item list-group-item-action active" href="account-profile.php">
                        <i class="ci-user me-2"></i>Profile Settings
                    </a>

                    <a class="list-group-item list-group-item-action" href="account-orders.php">
                        <i class="ci-bag me-2"></i>Orders History
                    </a>

                    <a class="list-group-item list-group-item-action" href="account-wishlist.html">
                        <i class="ci-heart me-2"></i>Wishlist
                    </a>

                    <a class="list-group-item list-group-item-action text-danger" href="logout.php">
                        <i class="ci-close-circle me-2"></i>Log Out
                    </a>

                </div>
            </div>

            <!-- Main -->
            <div class="col-lg-9 col-md-8">

                <!-- PROFILE INFO -->
                <div class="card mb-4">

                    <div class="card-header">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="account-profile.php" novalidate>
                            <input type="hidden" name="action" value="update_info">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <?= text_input([
                                        'name'  => 'first_name',
                                        'label' => 'First Name',
                                        'value' => $user['first_name'],
                                        'attributes' => 'required'
                                    ]) ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <?= text_input([
                                        'name'  => 'last_name',
                                        'label' => 'Last Name',
                                        'value' => $user['last_name'],
                                        'attributes' => 'required'
                                    ]) ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <?= text_input([
                                    'name'  => 'username',
                                    'label' => 'Username',
                                    'value' => $user['username'],
                                    'attributes' => 'required'
                                ]) ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <?= text_input([
                                        'name'  => 'email',
                                        'label' => 'Email Address',
                                        'value' => $user['email'],
                                        'attributes' => 'required type="email"'
                                    ]) ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <?= text_input([
                                        'name'  => 'phone_number',
                                        'label' => 'Phone Number',
                                        'value' => $user['phone_number'],
                                        'attributes' => 'required'
                                    ]) ?>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">
                                Save Changes
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once('files/footer.php'); ?>
