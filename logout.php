<?php
    session_start(); // Start the session
    session_destroy(); // Destroy all session data
?>
<html>
<head>
    <title>Log Out</title>
    <script>
        alert("Successfully logged out!");
        window.location = "index.php"; // Redirect to the landing page
    </script>
</head>
<body>
</body>
</html>