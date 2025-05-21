<?php
// Initialize variables
$errors = [];
$success = false;
$submittedData = null;
$formData = [
    'username' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize all inputs
    $formData['username'] = trim($_POST['username'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['confirm_password'] = $_POST['confirm_password'] ?? '';

    // Validate inputs
    if (empty($formData['username'])) {
        $errors['username'] = 'Username is required';
    } elseif (!preg_match('/^[a-z0-9_]{3,20}$/i', $formData['username'])) {
        $errors['username'] = '3-20 chars (letters, numbers, _)';
    }

    if (empty($formData['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($formData['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($formData['password']) < 8) {
        $errors['password'] = 'Must be at least 8 characters';
    }

    if ($formData['password'] !== $formData['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // Process if no errors
    if (empty($errors)) {
        $submittedData = $formData;
        $formData = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => ''
        ];
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h1>Registration Form</h1>
    
    <?php if ($success): ?>
        <div>
            <p>Registration successful! Below is the submitted data (for demonstration only):</p>
            <div>
                <h3>Submitted Data:</h3>
                <p>Username: <?= htmlspecialchars($submittedData['username']) ?></p>
                <p>Email: <?= htmlspecialchars($submittedData['email']) ?></p>
                <p>Password: <?= htmlspecialchars($submittedData['password']) ?></p>
                <p><em>(Password is shown for demo only - never do this in production)</em></p>
            </div>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($formData['username']) ?>">
            <?php if (isset($errors['username'])): ?>
                <span><?= $errors['username'] ?></span>
            <?php endif; ?>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($formData['email']) ?>">
            <?php if (isset($errors['email'])): ?>
                <span><?= $errors['email'] ?></span>
            <?php endif; ?>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <span><?= $errors['password'] ?></span>
            <?php endif; ?>
        </div>

        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
            <?php if (isset($errors['confirm_password'])): ?>
                <span><?= $errors['confirm_password'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Register</button>
    </form>
    
    <p><strong>Security Note:</strong> This demo shows plain text passwords for educational purposes only.</p>
</body>
</html>