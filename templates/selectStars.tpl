<select class="form-control form-select" name="exoplanet-star" required>
        {foreach from = $stars item = $star}
            <option value = "{$star->name}">{$star->name}</option>
        {/foreach}
</select>