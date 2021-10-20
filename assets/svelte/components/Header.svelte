<script>
    /* Components */
    import {Link} from "svelte-navigator"
    /* /Components */

    /* Asset */
    import {logo} from '../utils/asset'
    /* /Asset */

    /* Store */
    import {showUploadModal} from "../stores";
    /* /Store */

    let UploadModal

    showUploadModal.subscribe(async () => {
        UploadModal = (await import('../components/Media/UploadModal.svelte')).default;
    })
</script>

<svelte:component this={UploadModal}/>

<header class="bg-white shadow">
    <div class="container">
        <div class="flex items-center justify-between">
            <nav class="flex items-center">
                <Link to="/admin"><img class="w-36 mr-4" src="{logo}" alt="Codethereal Logo"></Link>
                <Link class="block p-3 hover:text-gray-600" to="/admin/media">Media</Link>
                <Link class="block p-3 hover:text-gray-600" to="/admin/stocks">Stocks</Link>
                <Link class="block p-3 hover:text-gray-600" to="/admin/currencies">Currencies</Link>
                <Link class="block p-3 hover:text-gray-600" to="/admin/offerings">Offerings</Link>
            </nav>
            <div>
                <button class="x-btn rounded-full bg-green-500 text-white hover:bg-green-600" on:click={() => showUploadModal.set(true)}>Upload File <i class="bi bi-upload"></i></button>
            </div>
        </div>
    </div>
</header>