<?php
require_once 'app/Views/partials/header.template.php';
?>
<body>
<a href="/tasks/create">Create</a>
<h3>Tasks</h3>
<ul>
    <?php foreach($tasks->getTasks() as $task): ?>
        <li>
            <a href="/tasks/<?php echo $task->getId()?>">
                <?php echo $task->getTitle(); ?>
            </a>
            <small>
                (<?php echo $task->getCreatedAt(); ?>)
            </small>

        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>