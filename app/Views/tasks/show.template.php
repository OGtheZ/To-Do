<?php
require_once 'app/Views/partials/header.template.php'; ?>
<body>
(<a href="/tasks">Back</a>)
<h3><?php echo $task->getTitle();?></h3>
<h6><?php echo $task->getCreatedAt();?></h6>
<form method="post" action="/tasks/<?php echo $task->getId(); ?>">
    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>
</body>
</html>