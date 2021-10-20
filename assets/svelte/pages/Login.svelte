<script>
    /* Components */
    import {navigate} from "svelte-navigator";
    /* /Components */

    /* Asset */
    import {logo, loginBackground} from '../utils/asset'
    /* /Asset */

    /* Utils */
    import {request} from "../utils/api";
    /* /Utils */

    /* Store */
    import {user} from "../stores"
    /* /Store */

    let email
    let password
    let showPassword = false
    let alert = false
    let alertMessage = ''

    $: type = showPassword ? 'text' : 'password'

    const handlePasswordInput = e => {
        // in here, you can switch on type and implement
        // whatever behaviour you need
        password = type.match(/^(number|range)$/) ? +e.target.value : e.target.value;
    };

    const handleSubmit = async () => {
        try {
            // todo to dynamic route
            const {data} = await request.post('/api/login_check', {
                username: email,
                password
            })

            if (data?.code > 300) {
                throw new Error(data.message)
            }

            user.set({username: email})
        } catch (err) {
            alert = true
            alertMessage = err.message
            setTimeout(() => alert = false, 5000)
        }
    }

    user.subscribe(u => {
        if (u) {
            navigate('/admin')
        }
    })
</script>

<div class="h-screen flex flex-col items-center justify-center bg-cover bg-no-repeat" style="background-image: url('{loginBackground}');">
    <div class="bg-white rounded-lg shadow-lg w-11/12 sm:w-3/5 lg:w-5/12 xl:w-4/12">
        <div class="p-4 flex justify-center">
            <img class="w-2/4 lg:w-1/4" src="{logo}" alt="Codethereal Logo">
        </div>
        <div class="p-4">
            <div class="mb-4 p-3 border-l-4 text-white bg-red-600 border-red-800" class:hidden={!alert} role="alert">
                <p>{alertMessage}</p>
            </div>
            <form class="w-full" on:submit|preventDefault={handleSubmit}>
                <div class="mb-3">
                    <label class="text-gray-800 block mb-1 text-base whitespace-nowrap" for="email">E-Mail <a href="/" class="text-xs float-right text-blue-400 hover:text-blue-500">Don't have an account?</a></label>
                    <input class="border-0 outline-none py-2 px-4 w-full border focus:border-gray-300 tracking-widest" id="email" type="email" bind:value={email} required autocomplete="email" placeholder="info@codethereal.net" onfocus="this.placeholder = ''" onblur="this.placeholder = 'info@codethereal.net'">
                </div>
                <div class="mb-3">
                    <label class="text-gray-800 block mb-1 text-base whitespace-nowrap" for="password">Password</label>
                    <div class="relative">
                        <input class="border-0 outline-none py-2 px-4 w-full border focus:border-gray-300 tracking-widest" id="password" {type} on:input={handlePasswordInput} required placeholder="********" onfocus="this.placeholder = ''" onblur="this.placeholder = '********'">
                        <span class="absolute right-0 top-0 block p-2 h-full cursor-pointer hover:bg-gray-200" on:click={() => showPassword = !showPassword}>{showPassword ? 'Hide' : 'Show'}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between sm:flex-row">
                    <a href="/" class="text-blue-400 hover:text-blue-500">Forgot password?</a>
                    <div class="flex items-center">
                        <input type="checkbox" id="remember"> <label for="remember" class="mx-1 sm:mx-2">Remember me</label>
                        <button class="x-btn bg-green-500 text-white hover:bg-green-600" type="submit">Login <i class="bi bi-arrow-return-right align-middle"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>