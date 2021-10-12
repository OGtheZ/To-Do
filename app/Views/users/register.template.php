<?php require_once "app/Views/partials/header.template.php"; ?>
<body>
<form action="/" method="POST">
    <label for="userName">New username:</label>
    <input type="text" name="userName" id="userName"><br>
    <label for="password">New password:</label>
    <input type="password" name="password" id="password"><br>
    <button type="submit">Register</button>
</form>
<a href="/">Back</a>
</body>
</html>