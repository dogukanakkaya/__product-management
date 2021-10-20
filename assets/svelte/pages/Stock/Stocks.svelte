<script>
    /* Components */
    import MainBox from "../../components/MainBox.svelte"
    import {Top} from "../../components/Table/exports.js"
    import Breadcrumb from "../../components/Breadcrumb.svelte"
    import PageNav from "../../components/PageNav.svelte"
    import {Link} from "svelte-navigator"
    /* /Components */
</script>

<PageNav>
    <Breadcrumb items={[
        {title: 'Stocks'}
    ]}/>
    <div>
        <Link to="/admin/stocks/create" class="x-btn rounded-full bg-gray-900 text-white hover:bg-black">Create <i class="bi bi-plus"></i></Link>
    </div>
</PageNav>

<MainBox>
    <Top>

    </Top>
</MainBox>