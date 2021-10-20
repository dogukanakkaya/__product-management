<script>
    /* Components */
    import Header from "./components/Header.svelte"
    import Login from "./pages/Login.svelte"
    import PrivateRoute from "./components/PrivateRoute.svelte"
    import {Router, Route} from "svelte-navigator"
    import Loadable from "svelte-loadable"
    /* /Components */

    /* Utils */
    import {request} from './utils/api'
    /* /Utils */

    /* Store */
    import {user} from "./stores"
    /* /Store */

    const getMe = async () => {
        const {data} = await request.get(`/api/me`)
        if (data.username) {
            user.set(data)
        }
    }
</script>

<Router>
    {#await getMe() then value}
        <PrivateRoute path="/admin/*">
            <Header/>

            <Router>
                <main class="container px-5 sm:px-0">
                    <Route path="/">
                        <Loadable loader={() => import("./pages/Home.svelte")}/>
                    </Route>

                    <Route path="/media">
                        <Loadable loader={() => import("./pages/Media.svelte")}/>
                    </Route>

                    <Route path="/stocks">
                        <Loadable loader={() => import("./pages/Stock/Stocks.svelte")}/>
                    </Route>
                    <Route path="/stocks/create">
                        <Loadable loader={() => import("./pages/Stock/Create.svelte")}/>
                    </Route>

                    <Route path="/currencies">
                        <Loadable loader={() => import("./pages/Currencies.svelte")}/>
                    </Route>

                    <Route path="/offerings">
                        <Loadable loader={() => import("./pages/Offerings.svelte")}/>
                    </Route>

                    <Route>
                        <Loadable loader={() => import("./pages/NotFound.svelte")}/>
                    </Route>
                </main>
            </Router>
        </PrivateRoute>

        <Route path="/login">
            <Login/>
        </Route>
    {/await}
</Router>
