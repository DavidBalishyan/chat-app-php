<?php
$conn = new mysqli('localhost', 'root', '', 'chat_app');
$result = $conn->query("SELECT messages.message, users.username, messages.created_at 
                        FROM messages 
                        JOIN users ON messages.user_id = users.id 
                        ORDER BY messages.created_at ASC");
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>" . htmlspecialchars($row['username']) . ":</strong> " . htmlspecialchars($row['message']) . " <em>(" . $row['created_at'] . ")</em></p>";
}
