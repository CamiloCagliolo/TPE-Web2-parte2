<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href='{$BASE_URL}'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>{$title}</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home">Exoplanets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {if $title != "Log in" && !$session}
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="login">Log in</a>
                        </li>
                    {/if}

                    {if $session}
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="logout">Log out</a>
                        </li>
                    {/if}

                    {if $title != "Register"}
                        <li class="nav-item">
                            <a class="nav-link" href="register">Register</a>
                        </li>
                    {/if}
                </ul>
            </div>
        </div>
</nav>

<div class="body">