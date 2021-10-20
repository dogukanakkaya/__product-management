<script>
    /* Components */
    import {Link} from "svelte-navigator"
    /* /Components */

    export let items
</script>

<nav class="my-8" aria-label="Breadcrumb">
    <ul class="flex">
        <li class="text-black font-bold flex items-center">
            <Link to="/admin">Home <i class="bi bi-chevron-right mx-3"></i></Link>
        </li>

        {#each items as item, idx}
            <!-- Check if last item or not -->
            {#if idx + 1 === items.length}
                <li class="text-black font-bold">
                    <span class="text-gray-500" aria-current="page">{item.title}</span>
                </li>
            {:else}
                <li class="text-black font-bold flex items-center">
                    <Link to={item.path}>{item.title} <i class="bi bi-chevron-right mx-3"></i></Link>
                </li>
            {/if}
        {/each}
    </ul>
</nav>