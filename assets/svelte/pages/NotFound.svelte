<script>
    /* Svelte */
    import { navigate } from "svelte-navigator"
    /* /Svelte */

    /* Asset */
    import {logo} from '../utils/asset'
    /* /Asset */
</script>

<div class="h-screen flex items-center justify-center flex-col">
    <i class="bi bi-exclamation-circle text-xl text-red-600"></i>
    <img class="w-48 my-2" src="{logo}" alt="Codethereal Logo">
    <h4>Sorry, but the page you are looking for not found.</h4>
    <p class="cursor-pointer underline text-blue-400 hover:text-blue-500" on:click="{() => navigate(-1)}">Go back</p>
</div>