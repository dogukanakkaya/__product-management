<script>
    export let perPage
</script>

<div>
    <select bind:value={perPage} class="x-input">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
    </select>
</div>