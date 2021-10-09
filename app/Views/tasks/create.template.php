<?php
require_once "app/Views/partials/header.template.php";
?>
<body>
<a href="/tasks">Back</a><br>
<form action="/tasks" method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title">
    <button type="submit">Create</button>
</form>
</body>
</html>
