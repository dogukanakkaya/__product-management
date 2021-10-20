<script>
    /* Store */
    import {user} from '../stores'
    /* /Store */

    let authUser
    user.subscribe(u => {
        authUser = u
    })
</script>

<div class="my-5">
    <h1 class="text-lg text-gray-700 font-semibold">Welcome {authUser.username || authUser.email}</h1> we were waiting for you...
</div>