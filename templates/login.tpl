{include file ="header.tpl"}

<form class="user-form">
    <div>
        <input type="text" name="user" placeholder="Username" class="form-control" required>
    </div>
    <div>
        <input type="password" name="pass" placeholder="Password" class="form-control" required>
    </div>
    <input class="btn btn-light" type="submit" name="submit" value="Log in">
    <div class="form-text">Don't have an account? You might want to <a href="register">register</a>, then.</div>
</form>

<div id="message"></div>

{include file="footer.tpl"}