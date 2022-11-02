{include file='header.tpl'}
<div class="options form-check">
    <span><input id="toggle-exoplanets" type="radio" name="object" value="exoplanets" class="form-check-input" checked>
        <label class="form-label" for="object">Add exoplanet</label></span>
    <span><input id="toggle-stars" type="radio" name="object" class="form-check-input" value="stars">
        <label class="form-label" for="object">Add star</label></span>
</div>

<div class='body'>
    <form id="exoplanet-form" class="exoplanet-form">
        <div>
            <label for="exoplanet-name" class="form-label">Name</label>
            <input class="form-control" type="text" name="exoplanet-name" placeholder="Exoplanet name..." required>
        </div>
        <div>
            <label for="exoplanet-mass" class="form-label">Mass (M<sub>J</sub>)</label>
            <input class="form-control" type="number" name="exoplanet-mass" step='0.001' required>
        </div>
        <div>
            <label for="exoplanet-radius" class="form-label">Radius (M<sub>J</sub>)</label>
            <input class="form-control" type="number" name="exoplanet-radius" step='0.001' required>
        </div>
        <div>
            <label for="exoplanet-method" class="form-label">Detection method</label>
            <span id="select-methods-container"></span>
        </div>
        <div>
            <label for="exoplanet-star" class="form-label">Host star</label>
            <span id="select-stars-container"></span>
        </div>
        <div class="submit">
            <input class="btn btn-dark" type="submit" value="Add exoplanet">
        </div>
    </form>

    <form id="star-form" class="star-form hidden">
        <div>
            <label for="star-name" class="form-label">Name</label>
            <input class="form-control" type="text" name="star-name" placeholder="Star name..." required>
        </div>
        <div>
            <label for="star-mass" class="form-label">Mass (M<sub>&#x2609</sub>)</label>
            <input class="form-control" type="number" name="star-mass" step='0.001' required>
        </div>
        <div>
            <label for="star-radius" class="form-label">Radius (M<sub>&#x2609</sub>)</label>
            <input class="form-control" type="number" name="star-radius" step='0.001' required>
        </div>
        <div>
            <label for="star-distance" class="form-label">Distance (ly)</label>
            <input class="form-control" type="number" name="star-distance" step='0.001' required>
        </div>
        <div>
            <label for="star-type" class="form-label">Type</label>
            <input class="form-control" type="text" name="star-type" required>
        </div>
        <div class="submit">
            <input class="btn btn-dark" type="submit" value="Add star">
        </div>
    </form>

    <div id="message">
    </div>

    <a class="go-back" href="tables">Go back</a>
</div>





{include file='footer.tpl'}