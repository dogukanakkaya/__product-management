<script>
    /* Components */
    import MainBox from "../components/MainBox.svelte"
    import {THead, Top, Bottom, PerPageSelect, SearchInput, ShowingRecordCount, Pagination} from "../components/Table/exports.js"
    import Breadcrumb from "../components/Breadcrumb.svelte"
    import PageNav from "../components/PageNav.svelte"
    /* /Components */

    /* Utils */
    import {request} from '../utils/api'
    import {debounce} from '../utils/event'
    import {route} from '../utils/route'
    /* /Utils */


    let currencies = []
    let count = 0
    let page = 1
    let search = ''
    let perPage = '10'
    let orderByField = 'createdAt'
    let orderByDirection = 'DESC'
    $: lastPage = Math.ceil(count / perPage)
    $: endpoint = route('api_currencies_get', {q: search, perPage, page, orderByField, orderByDirection})
    //$: history.replaceState({}, '', `?q=${search}&perPage=${perPage}&page=${page}&orderByField=${orderByField}&orderByDirection=${orderByDirection}`)

    $: {
        (async () => {
            const {data} = await request.get(endpoint)
            currencies = data.data
            count = data.count
        })()
    }

    // TODO: understand the memory leak
    const handleSearch = e => debounce(() => search = e.target.value)

    const handleOrderBy = field => {
        // If already clicked to same field inverse the direction
        if (field === orderByField) {
            orderByDirection = orderByDirection === 'DESC' ? 'ASC' : 'DESC'
        } else {
            orderByField = field
        }
    }

    const destroy = async id => {
        if (confirm('Are you sure to delete this currency?')) {
            const {data} = await request.delete(route('api_currencies_delete', {id}))

            if (data.status) {
                currencies = currencies.filter(currency => currency.id !== id)
                count = count - 1 // temporary solution, will depend on multiple deletion etc.
            }
        }
    }
</script>

<PageNav>
    <Breadcrumb items={[
        {title: 'Currencies'}
    ]}/>
</PageNav>

<MainBox>
    <Top>
        <PerPageSelect bind:perPage={perPage}/>
        <SearchInput on:input={handleSearch}/>
    </Top>
    <div class="overflow-x-auto sm:overflow-x-hidden">
        <table class="w-full leading-normal">
            <THead headers={[
                {title: 'Name', onclick: () => handleOrderBy('name')},
                {title: 'Created At', onclick: () => handleOrderBy('createdAt')},
                {title: ''}
            ]}/>
            <tbody>
                {#each currencies as currency}
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-5 py-5">
                            <p class="text-gray-900 whitespace-no-wrap text-lg">{currency.name}</p>
                        </td>
                        <td class="px-5 py-5">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {currency.createdAt}
                            </p>
                        </td>
                        <td class="px-5 py-5">
                            <button class="x-btn relative inline-block font-semibold text-red-900 leading-tight bg-red-300 rounded mr-2" on:click={() => destroy(currency.id)}>
                                DELETE <i class="bi bi-trash align-middle"></i>
                            </button>
                        </td>
                        <!--
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight bg-green-100 rounded-full">
                                BUY
                            </span>
                        </td>
                        -->
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
    <Bottom>
        <ShowingRecordCount {count} {perPage} {page} {lastPage}/>
        <Pagination on:changePage={e => page = e.detail.page} on:click={(i) => page = i} {page} {lastPage}/>
    </Bottom>
</MainBox>