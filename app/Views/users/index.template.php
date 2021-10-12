<?php require_once "app/Views/partials/header.template.php"; ?>

<body>
<div class="login">
<form action="/home" method="POST">
    <label for="userName">Username:</label>
    <input type="text" name="userName" id="userName"><br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password"><br><br>
    <button type="submit">Login</button>
</form>
(<a href="/register">Register</a>)
</div>
</body>
</html>