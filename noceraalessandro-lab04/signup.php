<?php include "top.html"; ?>

<fieldset>
    <legend>New User Singup</legend>
    <form action="singup-submit.php" method="POST">
        <strong>Name:</strong> <input type="text" name="name" maxlength="16"><br>
        <strong>Gender:</strong> <input type="radio" value="M" name="gender"> Male <input type="radio" value="F" name="gender" checked="checked"> Female <br>
        <strong>Age:</strong> <input type="text" name="age" maxlength="2" size ="6"><br>
        <strong>Personality type:</strong> <input type="text" name="Personality" size ="6" maxlength="4"><a href=http://www.humanmetrics.com/cgi-win/JTypes2.asp >(Don't know your type?)</a><br>
        <strong>Favorite OS:</strong> <select name="OS">
                        <option>Windows</option>
                        <option>Mac OS</option>
                        <option selected="selected">Linux</option>
                </select><br>
        <strong>Seaking age:</strong><input type="text" name="minage" maxlength="2" value="min" size ="6"> to <input type="text" name="maxage" value="max" maxlength="2" size ="6"><br>
        <input type="submit" value ="Sing Up">
    </form>
</fieldset>


<?php include "bottom.html"; ?>