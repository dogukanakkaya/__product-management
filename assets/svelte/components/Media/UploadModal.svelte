<script>
    /* Components */
    import Dropzone from "svelte-file-dropzone"
    import {ImageCard, FileCard} from "./exports"
    /* /Components */

    /* Utils */
    import {request} from "../../utils/api"
    import {route} from "../../utils/route"
    import {isImage} from "../../utils/helpers"
    /* /Utils */

    /* Store */
    import {showUploadModal} from "../../stores";
    /* /Store */


    let showModal
    let files = {accepted: [], rejected: []}

    showUploadModal.subscribe(value => showModal = value)

    const handleSelect = e => {
        const { acceptedFiles, fileRejections } = e.detail

        // Read each file to show preview
        acceptedFiles.forEach(file => {
            const fileReader = new FileReader()
            fileReader.readAsDataURL(file)

            file.extension = file.name.split('.').pop()

            fileReader.onload = e => {
                file.source = e.target.result
                files.accepted = [...files.accepted, file]
            }
        })

        files.rejected = [...files.rejected, ...fileRejections]
    }

    const handleUpload = async () => {
        const formData = new FormData()
        files.accepted.forEach(file => {
            formData.append('files[]', file)
        })

        const {data} = await request.post(route('api_files_upload'), formData)

        if (data.status) {
            files = {accepted: [], rejected: []}
            showUploadModal.set(false)
        }
    }

    const remove = idx => {
        files.accepted.splice(idx, 1)
        files.accepted = [...files.accepted]
    }

    // Change property names of object to use compatible with component
    $: acceptedFiles = files.accepted.map(file => ({
        originalName: file.name,
        size: file.size,
        source: file.source,
        extension: file.extension
    }))
</script>

<div class="min-w-screen h-screen animated fadeIn faster fixed flex justify-center items-center inset-0 z-50" class:hidden={!showModal}>
    <div class="absolute bg-black opacity-70 inset-0 z-0"></div>
    <div class="w-full max-w-lg md:max-w-2xl lg:max-w-4xl xl:max-w-6xl relative shadow-lg bg-white">
        <div class="p-5">
            <Dropzone accept={['image/*', '.txt', '.csv', '.xlsx', '.docx', '.pdf']} on:drop={handleSelect} containerClasses="border-2 border-dashed w-full h-56 flex items-center justify-center flex-col cursor-pointer" containerStyles="background: repeating-linear-gradient(-55deg, #fbfbfb, #fbfbfb 5px, #fff 5px, #fff 10px)">
                <h1 class="font-semibold text-gray-800 text-lg">Drag and drop or click here to upload your files</h1>
                <p>(Please wait until your file uploads completes then press <span class="font-semibold text-gray-800">save</span>)</p>
            </Dropzone>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-5">
                {#each acceptedFiles as file, idx}
                    {#if isImage(file.extension)}
                        <ImageCard {file} clientUpload={true} on:click={() => remove(idx)}/>
                    {:else}
                        <FileCard {file} on:click={() => remove(idx)}/>
                    {/if}
                {/each}
            </div>
        </div>
        <div class="bg-gray-50 flex justify-end p-5">
            <button class="x-btn bg-white border text-gray-600 shadow-sm rounded-full mr-2 hover:shadow-lg hover:bg-gray-100" on:click={() => showUploadModal.set(false)}>Cancel</button>
            <button class="x-btn bg-blue-500 border border-blue-500 shadow-sm text-white rounded-full hover:shadow-lg hover:bg-blue-600" on:click={handleUpload}>Save <i class="bi bi-save"></i></button>
        </div>
    </div>
</div>