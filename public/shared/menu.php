<ul>
    <?php foreach ($userMenu as $element): ?>
    <li>
        <a href="<?php echo $element['url']; ?>">
            <?php echo $element['icon']; ?>
            <div><?php echo $element['name']; ?></div>
        </a>
    </li>
    <?php endforeach; ?>
</ul>