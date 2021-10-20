<script>
    export let headers
</script>

<thead>
    <tr class="border-b-4">
        {#each headers as header}
            <th class="px-5 py-3 border-gray-200 text-left text-xs font-semibold text-gray-800 uppercase tracking-wider" class:cursor-pointer={typeof header.onclick === 'function'} on:click={header.onclick ?? null}>
                {header.title}
            </th>
        {/each}
    </tr>
</thead>