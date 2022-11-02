{include file = "header.tpl"}
<section class="main-text">
    <h1>Welcome to the website for directly observed exoplanets!</h1>

    <p>"Exoplanet" is the word we use when we refer to planets outside of our star system. Normally, exoplanets are very
        difficult to detect, mainly because they're too small and faint to be observed, in contrast to their host stars
        (except, maybe, for <span>rogue planets</span>, which have no star at all, but are even more
        difficult to detect). Usually, the methods to detect exoplanets are indirect and rely on transits, that is, when
        a
        planet interferes with the direct line of sight between the Earth and its host star, effectively decreasing the
        apparent brightness. This method requires, for instance, that the orbit plane must be parallel to Earth's line
        of
        sight, which is a pretty restrictive condition, and that it's period has to be short enough for us to detect a
        periodicity without having to permanently observe the star (for example, if the orbital period of an exoplanet
        were
        like Pluto's 248 years, we wouldn't be able to figure out if the decrease in brightness was a product of an
        exoplanet or instead something else, until 248 years had passed from the first observation, supposing our
        telescopes
        were also aiming at that particular point 248 years later).</p>

    <p>Given all of this, and the tremendous distances of space, it isn't hard to guess that it's almost impossible to
        get a
        clear picture of an exoplanet (we can't even get one from Neptune without sending probes there). Normally, we
        can't
        even get a simple image of a dot, either. But, nevertheless, with the help of algorithms and telescopes we can
        combine several images to get an indirect picture of directly observed exoplanets. There is a variety of methods
        that isolate an exoplanet from the background light of their star, listed below:</p>

    <ul>
        {foreach from = $methods item = $method}
            <li>{$method->name_acronym}: {$method->name_complete}</li>
        {/foreach}
    </ul>

    <p>You can see complete tables of directly observed exoplanets and their host stars <a href="tables">here</a>.</p>
</section>


{include file = "footer.tpl"}