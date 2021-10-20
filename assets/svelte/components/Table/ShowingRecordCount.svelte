<script>
    export let count
    export let perPage
    export let page
    export let lastPage
</script>

<span class="text-sm text-gray-900">
    {#if parseInt(count) === 0}
        Can't find any record
    {:else}
        Showing {page === 1 ? page : perPage * (page - 1)} to {page === lastPage ? count : perPage * page} of <b>{count}</b>
    {/if}
</span>