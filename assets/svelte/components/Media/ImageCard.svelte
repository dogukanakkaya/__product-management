<script>
    /* Svelte */
    import {fly} from 'svelte/transition'
    /* /Svelte */

    /* Utils */
    import {bytesToSize, uploads} from '../../utils/helpers'
    import {request} from "../../utils/api"
    import {route} from "../../utils/route"
    /* /Utils */

    export let file
    export let clientUpload = false

    let imageFit = true
    let hovering = false

    const updateField = async (id, data) => {
        const response = await request.patch(route('api_files_update', {id}), data)
    }
</script>

<div class="relative flex flex-col justify-between items-center bg-white shadow rounded-t-lg" on:mouseenter={() => hovering = true} on:mouseleave={() => hovering = false}>
    <img class={`w-full max-h-48 rounded ${imageFit ? 'object-cover' : 'object-contain'}`} src={clientUpload ? file.source : uploads({path: file.path, w: 500})} alt="">
    <div class="text-center w-full">
        <p class="text-base text-gray-800">
            {#if !clientUpload}
                <input class="w-full text-center outline-none" type="text" value="{file.originalName}" on:focusout={e => updateField(file.id, {originalName: e.target.value})}>
            {:else}
                {file.originalName}
            {/if}
        </p>
        <span class="text-xs">{bytesToSize(file.size)}</span>
    </div>
    {#if hovering}
        <div class="absolute right-1 top-1" in:fly="{{y: -40}}" out:fly={{y: -40}}>
            <span class="mb-1 w-6 h-6 cursor-pointer flex justify-center items-center text-xs bg-red-500 text-white rounded-full hover:bg-red-600" on:click><i class="bi bi-trash"></i></span>
            <span class="w-6 h-6 cursor-pointer flex justify-center items-center text-xs bg-blue-500 text-white rounded-full hover:bg-blue-600" on:click={() => imageFit = !imageFit}><i class="bi bi-fullscreen-exit"></i></span>
        </div>
    {/if}
</div>