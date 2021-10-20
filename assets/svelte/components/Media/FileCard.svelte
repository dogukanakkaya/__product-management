<script>
    /* Utils */
    import {bytesToSize} from '../../utils/helpers'
    import {documentIcons} from '../../utils/asset'
    /* /Utils */

    export let file
</script>

<div class="relative flex flex-col justify-between items-center bg-white shadow rounded-t-lg">
    <div class="flex items-center justify-center h-full">
        <img class="w-32 rounded" src={documentIcons[file.extension]} alt="">
    </div>
    <div class="text-center">
        <p class="text-base text-gray-800">{file.originalName}</p>
        <span class="text-xs">{bytesToSize(file.size)}</span>
    </div>
    <div class="absolute right-1 top-1">
        <span class="w-6 h-6 cursor-pointer flex justify-center items-center text-xs bg-red-500 text-white rounded-full hover:bg-red-600" on:click><i class="bi bi-trash"></i></span>
    </div>
</div>