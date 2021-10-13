<?php
require_once 'app/Views/partials/header.template.php';
?>
<body>
<form action="/logout" method="post">
    <input type="submit" name="logout" value="Logout">
</form>
<br>
<form action="/tasks/create" method="get">
    <input type="submit" name="create" value="Create">
</form>
<br>
<h3>Your tasks:</h3>
<ul>
    <?php foreach($tasks->getTasks() as $task): ?>
        <li>
            <a href="/tasks/<?php echo $task->getId()?>">
                <?php echo $task->getTitle(); ?>
            </a>
            <small>
                (<?php echo "Created at: " . $task->getCreatedAt(); ?>)
            </small>

        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>