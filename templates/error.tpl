{include file = "header.tpl"}
<div>
    {if $error eq "logged"}
    <h2 class="alert alert-danger" >There must be an error! You're already logged in.</h2>

    {elseif $error eq "permission"}
        <h2 class="alert alert-danger">You have no permission to be here or do this.</h2>

    {elseif $error eq "notlogged"}
        <h2 class="alert alert-danger">You're trying to log out when you weren't even logged in.</h2>
        
    {elseif $error eq "cantregister"}
        <h2 class="alert alert-danger">Why would you want to register again when you clearly already have an account?</h2>
    {else}
        <h2 class="alert alert-danger" >Error 404. Page not found.</h2>
    {/if}
    <a href="home">Return</a>
</div>

{include file = "footer.tpl"}