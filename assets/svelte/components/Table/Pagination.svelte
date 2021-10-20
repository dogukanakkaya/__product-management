<script>
    /* Svelte */
    import { createEventDispatcher } from 'svelte';
    /* /Svelte */

    const dispatch = createEventDispatcher();

    export let page
    export let lastPage

    // Check for if page available (less than 0 or greater than max) and dispatch
    const handlePageChange = page => {
        if (page <= 0) {
            dispatch('changePage', {page: 1})
        } else if (page > lastPage) {
            dispatch('changePage', {page: lastPage})
        } else {
            dispatch('changePage', {page})
        }
    }
</script>

<ul class="flex mt-2">
    <li on:click={() => handlePageChange(page - 1)} class="text-gray-700 px-4 py-2 cursor-pointer border hover:bg-gray-200"><i class="bi bi-chevron-double-left"></i></li>
    {#each Array(lastPage) as _, idx}
        <li on:click={() => handlePageChange(idx + 1)} class={`text-gray-700 px-4 py-2 cursor-pointer border hover:bg-gray-200 ${page === idx + 1 ? 'bg-gray-200' : ''}`}>{idx + 1}</li>
    {/each}
    <li on:click={() => handlePageChange(page + 1)} class="text-gray-700 px-4 py-2 cursor-pointer border hover:bg-gray-200"><i class="bi bi-chevron-double-right"></i></li>
</ul>