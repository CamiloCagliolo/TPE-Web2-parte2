<select class="form-control" name="exoplanet-method" required>
{if isset($short)}
    {foreach from = $methods item=$method}
        <option value = {$method->name_acronym}>{$method->name_acronym}</option>
    {/foreach}
{else}
    {foreach from = $methods item=$method}
        <option value = {$method->name_acronym}>{$method->name_acronym}: {$method->name_complete}</option>
    {/foreach}
{/if}
        
</select>