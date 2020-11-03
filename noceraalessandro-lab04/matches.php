<?php include "top.html"; ?>
<fieldset>
    <legend> Returning User</legend>
    <form action="matches-submit.php" method="GET">
        <strong>Name:</strong><input type="text" name="name" maxlength="16"><br>
        <input type="submit" value ="View My Matches">
    </form>
</fieldset>
<?php include "bottom.html"; ?>