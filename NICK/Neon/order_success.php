<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    header('Location: index.php');
    exit();
}

$conn = getDBConnection();
$user_id = getUserId();

// Fetch order items to display
$stmt = $conn->prepare("
    SELECT p.title, p.image_path as image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    JOIN orders o ON oi.order_id = o.id
    WHERE oi.order_id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$ordered_items = [];
while ($row = $result->fetch_assoc()) {
    $ordered_items[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Order Successful | NEON BLADE</title>
<base href="/NICK/Neon/">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    :root {
      --primary: #ff2a6d;
      --secondary: #05d9e8;
      --dark: #0d0221;
      --dark-alt: #1a1a2e;
      --light: #d1f7ff;
      --success: #2ecc71;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: #111;
        color: #fff;
        margin: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    header {
        background: rgba(13, 2, 33, 0.9);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    nav { display: flex; align-items: center; gap: 20px; }

    header img {
        width: 60px;
    }
    nav a {
        color: #fff;
        text-decoration: none;
        margin: 0 10px;
        font-weight: 500;
    }
    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--secondary);
    }
    .user-menu { position: relative; display: flex; align-items: center; }
    .user-menu .profile-pic { cursor: pointer; }
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 55px;
      right: 0;
      background: var(--dark-alt);
      border-radius: 8px;
      padding: 0.5rem 0;
      list-style: none;
      width: 150px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      border: 1px solid rgba(255,255,255,0.1);
    }
    .dropdown-menu.show { display: block; }
    .dropdown-menu a { display: block; padding: 0.75rem 1.5rem; color: var(--light); text-decoration: none; transition: background-color 0.2s; }
    .dropdown-menu a:hover { background-color: var(--primary); color: white !important; }
    .success-container {
        text-align: center;
        margin: auto;
        padding: 40px 20px;
        max-width: 600px;
    }
    .success-icon {
        font-size: 5rem;
        color: var(--success);
        margin-bottom: 20px;
    }
    .success-container h1 {
        font-size: 2.5rem;
        color: var(--success);
        margin-bottom: 15px;
    }
    .success-container p {
        font-size: 1.1rem;
        margin-bottom: 30px;
    }
    .home-btn {
        display: inline-block;
        padding: 12px 30px;
        background: var(--primary);
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
        transition: background 0.3s;
    }
    .home-btn:hover {
        background: #d10000;
    }
    .purchased-items {
        margin-top: 40px;
        text-align: left;
    }
    .purchased-items h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        border-bottom: 1px solid #444;
        padding-bottom: 10px;
    }
    .item-card {
        display: flex;
        align-items: center;
        background: #222;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .item-card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 20px;
    }
    .item-details {
        flex-grow: 1;
    }
    .item-details h4 {
        font-size: 1.2rem;
        margin: 0 0 10px;
    }
    .download-btn {
        padding: 8px 20px;
        background: var(--secondary);
        color: var(--dark);
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
    }
    footer {
        text-align: center;
        padding: 20px;
        background: #d10000;
    }
</style>
</head>
<body>

<div class="success-container">
    <div class="success-icon"><i class="fas fa-check-circle"></i></div>
    <h1>Thank You!</h1>
    <p>Your payment was successful.</p>
    <p>Download your games now!</p>
    <a href="index.php" class="home-btn">Go to Homepage</a>

    <?php if (!empty($ordered_items)): ?>
    <div class="purchased-items">
        <h2>Your Games</h2>
        <?php foreach ($ordered_items as $item): ?>
            <div class="item-card">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                <div class="item-details">
                    <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                    <a href="#" class="download-btn"><i class="fas fa-download"></i> Download</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>