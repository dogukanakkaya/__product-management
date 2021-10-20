<script>
    /* Svelte */
    import {onMount} from "svelte"
    /* /Svelte */

    /* Components */
    import Breadcrumb from "../components/Breadcrumb.svelte"
    import PageNav from "../components/PageNav.svelte"
    import {ImageCard, FileCard} from "../components/Media/exports"
    /* /Components */

    /* Utils */
    import {request} from '../utils/api'
    import {debounce} from '../utils/event'
    import {route} from '../utils/route'
    import {isImage} from '../utils/helpers'
    /* /Utils */


    let media = []
    let count = -1
    let search = ''
    let showingCount = 0
    let lastIncomingDataCount = 0
    $: endpoint = route('api_files_get', {start: showingCount})

    const mediaLoaderObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                showingCount += lastIncomingDataCount
            }
        })
    }, {threshold: 1.0})

    onMount(() => {
        mediaLoaderObserver.observe(document.getElementById('loader'))
    })

    // On search, get only searched result from back-end and show only searched ones
    const fetchMedia = async endpoint => {
        const {data} = await request.get(endpoint)
        media = [...media, ...data.data]
        lastIncomingDataCount = data.data.length
        count = data.count
    }

    $: fetchMedia(endpoint)

    const handleSearch = e => debounce(() => search = e.target.value, 750)

    const destroy = async id => {
        if (confirm('Are you sure to delete this file?')) {
            const {data} = await request.delete(route('api_files_delete', {id}))

            if (data.status) {
                media = media.filter(file => file.id !== id)
            }
        }
    }

    $: filteredMedia = media.filter(file => file.originalName.toLowerCase().indexOf(search.toLowerCase()) !== -1);
</script>

<PageNav>
    <Breadcrumb items={[
        {title: 'Media'}
    ]}/>
</PageNav>

<div class="mb-5 flex flex-col items-center gap-2 sm:flex-row">
    <span>Search for</span>
    <input class="x-input max-w-max" on:input={handleSearch} placeholder="..." type="search">
</div>

<div class="min-h-screen mb-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-5" id="media-container">
        {#each filteredMedia as file}
            {#if isImage(file.extension)}
                <ImageCard {file} on:click={() => destroy(file.id)}/>
            {:else}
                <FileCard {file} on:click={() => destroy(file.id)}/>
            {/if}
        {/each}
    </div>
</div>

{#if parseInt(count) !== media.length}
    <div class="block text-center" id="loader">Loading...</div>
{/if}