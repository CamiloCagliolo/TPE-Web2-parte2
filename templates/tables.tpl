{if isset($exoplanets)}
    <h3>Here is a table with all directly observed exoplanets.</h3>
    
    <table class="table">
        <thead>
            <th>Name</th>
            <th>Mass (M<sub>J</sub>)</th>
            <th>Radius (R<sub>J</sub>)</th>
            <th>Detection method</th>
            <th>Host star</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            {foreach from=$exoplanets item=$exoplanet}
                <tr>
                    <td>{$exoplanet -> name}</td>
                    <td>{$exoplanet -> mass}</td>
                    <td>{$exoplanet -> radius}</td>
                    <td>{$exoplanet -> method}</td>
                    <td>{$exoplanet -> star}</td>
                    {if $session}
                        <td><input type="button" value="Edit" class="edit-btn btn btn-dark" id="edit-exoplanets-{$exoplanet->id}">
                        </td>
                        <td><input type="button" value="Delete" class="delete-btn btn btn-dark"
                                id="del-exoplanets-{$exoplanet->id}"></td>
                    {/if}
                </tr>
            {/foreach}
        </tbody>
    </table>
    {if $exoplanets|@count eq 0}
        <div class="alert alert-warning" role="alert">There are no items that apply to the current filters.</div>
    {/if}
{/if}

{if isset($stars)}
    <h3>These are all the registered stars with directly imaged exoplanets.</h3>

    <table class="table">
        <thead>
            <th>Name</th>
            <th>Mass (M<sub>&#x2609</sub>)</th>
            <th>Radius (R<sub>&#x2609</sub>)</th>
            <th>Distance (ly)</th>
            <th>Spectral type</th>
        </thead>
        <tbody>
            {foreach from=$stars item=$star}
                <tr>
                    <td>{$star -> name}</td>
                    <td>{$star -> mass}</td>
                    <td>{$star -> radius}</td>
                    <td>{$star -> distance}</td>
                    <td>{$star -> type}</td>
                    {if $session}
                        <td><input type="button" value="Edit" class="edit-btn btn btn-dark" id="edit-stars-{$star->id}"></td>
                        <td><input type="button" value="Delete" class="delete-btn btn btn-dark" id="del-stars-{$star->id}"></td>
                    {/if}
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}

{if $session}
    <div class="alert alert-success">
        <p>Seems like you're logged in as an administrator. You can edit these tables from here, or add a newly discovered
            exoplanet by clicking <a href="add">here</a>.</p>
    </div>
{/if}