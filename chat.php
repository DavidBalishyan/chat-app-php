<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'chat_app');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
}

// Fetch messages
$result = $conn->query("SELECT messages.message, users.username, messages.created_at 
                        FROM messages 
                        JOIN users ON messages.user_id = users.id 
                        ORDER BY messages.created_at ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
</head>
<body>
    <h1>Chat Room</h1>
    <div id="chat-box">
        <?php while ($row = $result->fetch_assoc()): ?>
            <p><strong><?= htmlspecialchars($row['username']) ?>:</strong> <?= htmlspecialchars($row['message']) ?> <em>(<?= $row['created_at'] ?>)</em></p>
        <?php endwhile; ?>
    </div>
    <form method="POST">
        <textarea name="message" placeholder="Type your message here..." required></textarea>
        <button type="submit">Send</button>
    </form>
    <button onclick="location.reload()">Refresh</button>
    <a href="logout.php"><button>Logout</button></a>
    <script>
setInterval(() => {
    fetch('fetch_messages.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('chat-box').innerHTML = data;
        });
}, 3000); // Refresh every 3 seconds
</script>


</body>
</html>
