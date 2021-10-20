<script>
    /* Svelte */
    import {onMount} from 'svelte'
    /* /Svelte */

    /* Components */
    import MainBox from "../../components/MainBox.svelte"
    import Breadcrumb from "../../components/Breadcrumb.svelte"
    import {TabControl, TabItem, TabContent} from "../../components/Tab/exports"
    import PageNav from "../../components/PageNav.svelte"
    /* /Components */

    /* Asset */
    import {imagePlaceholder} from '../../utils/asset'
    /* /Asset */

    /* Utils */
    import {isRequired} from '../../utils/validation'
    import {route} from "../../utils/route";
    import {request} from "../../utils/api";
    import {combinations as createCombinations, reCombineWithExtra} from "../../utils/helpers";
    /* /Utils */

    let activeTab = 'general'
    const setActiveTab = tab => {
        activeTab = tab
    }

    let options = []
    let variations = new Map()
    $: combinations = variations.size > 0 ? reCombineWithExtra(createCombinations([...variations.values()]), {price: 0.00, currency: 1}) : []

    onMount(async () => {
        const {data} = await request.get(route('api_stocks_options'))
        options = data.data
    })

    const handleOptionChange = e => {
        const selected = []
        e.target.selectedOptions.forEach(opt => {
            selected.push(JSON.parse(opt.value))
        })

        variations = variations.set(e.target.id, selected)
    }

    const removeCombination = idx => {
        // Svelte does not re assign the value after splice so i must do it manually
        combinations.splice(idx, 1)
        combinations = [...combinations]
    }

    const handleSubmit = async e => {
        const formData = new FormData(e.target)
        const data = {};
        for (let field of formData) {
            const [key, value] = field;
            data[key] = value;
        }
        console.log(data)
    }

    $: console.log(combinations)
</script>

<PageNav>
    <Breadcrumb items={[
        {title: 'Stocks', path: '/admin/stocks'},
        {title: 'Create'}
    ]}/>
</PageNav>

<TabControl>
    <TabItem active={activeTab === 'general'} on:click={() => setActiveTab('general')}>General</TabItem>
    <TabItem active={activeTab === 'variants'} on:click={() => setActiveTab('variants')}>Variants</TabItem>
</TabControl>

<form on:submit|preventDefault={handleSubmit}>
    <MainBox>
        <TabContent active={activeTab === 'general'}>
            <div class="md:grid grid-cols-2 gap-4 mb-5">
                <div class="mb-5 md:mb-0">
                    <label class="x-label" for="stock-name">Stock</label>
                    <input class="x-input" id="stock-name" type="text" placeholder="iPhone 12">
                </div>
                <div>
                    <label class="x-label" for="stock-category">Category</label>
                    <select class="x-input" id="stock-category">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>
        </TabContent>
        <TabContent active={activeTab === 'variants'}>
            {#each options as option}
                <div class="mb-5">
                    <label class="x-label" for={`stock-option-${option.id}`}>{option.name}</label>
                    <select class="x-input" id={`stock-option-${option.id}`} on:change={handleOptionChange} multiple>
                        {#each option.values as value}
                            <option value={JSON.stringify(value)}>{value.name}</option>
                        {/each}
                    </select>
                </div>
            {/each}

            {#if combinations.length}
                <div class="grid grid-cols-4 gap-4">
                    {#each combinations as combination, i}
                        <div class="relative flex items-center justify-center flex-col p-4 shadow-inner bg-gray-50 border rounded">
                            <img class="w-36" src={imagePlaceholder} alt="">
                            <ul class="flex items-center justify-center mt-5">
                                {#each combination.items as variant}
                                    <li class="text-base text-gray-700 font-semibold variant-text">{variant.name}</li>
                                {/each}
                            </ul>
                            <div>
                                <div class="flex">
                                    <!-- TODO: all combiations change ? -->
                                    <select class="px-3 py-2 outline-none appearance-none bg-gray-200 w-max border" on:change={e => combination.extra.currency = e.target.value}>
                                        <option value="1">₺</option>
                                        <option value="2">$</option>
                                        <option value="3">€</option>
                                    </select>
                                    <input class="px-3 py-2 outline-none border" type="text" placeholder="100.00" value={combination.extra.price} on:input={e => combination.extra.price = e.target.value}>
                                </div>
                            </div>
                            <div class="absolute right-1 top-1">
                                <span class="w-6 h-6 cursor-pointer flex justify-center items-center text-xs bg-red-500 text-white rounded-full hover:bg-red-600" on:click={() => removeCombination(i)}><i class="bi bi-trash"></i></span>
                            </div>
                        </div>
                    {/each}
                </div>
            {/if}
        </TabContent>
    </MainBox>
    <div class="flex justify-end mt-5">
        <button class="x-btn rounded-full bg-blue-500 text-white hover:bg-blue-600">Save <i class="bi bi-save"></i></button>
    </div>
</form>