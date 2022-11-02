{include file = "header.tpl"}

<form class="user-form">
    <div>
        <input type="text" name="user" placeholder="Username" class="form-control" required>
    </div>
    <div>
        <input type="password" name="pass" placeholder="Password" class="form-control" required>
    </div>
    <input class="btn btn-light" type="submit" name="submit" value="Register">
    <div class="form-text">Remember to read our <a href="terms">terms and conditions</a> before registering.</div>
</form>

<div id="message"></div>

{include file = "footer.tpl"}