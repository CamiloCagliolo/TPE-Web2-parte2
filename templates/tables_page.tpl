{include file="header.tpl"}
<p class="question">What list do you want to see?</p>
<div class="div-btns">
    <input type="button" value="Exoplanets" id="exoplanets-btn" class="btn btn-dark">
    <input type="button" value="Host stars" id="stars-btn" class="btn btn-dark">
</div>

<div class="filter form-check hidden-block">
    <span>Filter by:</span>
    <span><input id="filter-none" type="radio" name="filter" value="filter-none" class="form-check-input" checked>
        <label class="form-label" for="filter">None</label></span>
    <span><input id="filter-method" type="radio" name="filter" value="filter-method" class="form-check-input">
        <label class="form-label" for="filter">Methods</label></span>
    <span><input id="filter-star" type="radio" name="filter" value="filter-star" class="form-check-input">
        <label class="form-label" for="filter">Stars</label></span>
    <span id='select-container'></span>
    <span><input class="btn btn-dark hidden-block" type="button" name="filter" value="Confirm" id="filter-btn"></span>
</div>

<div id="table" class="tables-container">
</div>

<div id="message" class="alert"></div>
{include file="footer.tpl"}