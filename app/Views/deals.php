<a href="/">Application</a>
<ul>
    <?php foreach ($deals as $deal): ?>
        <li>
            <?php echo $deal['sum']; ?>
            <form method="post" action="/deals/<?php echo $deal['id'] ?>">
                <input type="hidden" name="email" value="<?php echo $deal['email'] ?>">
                <button type="submit">Send offer</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>