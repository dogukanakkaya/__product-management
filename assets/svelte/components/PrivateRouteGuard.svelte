<script>
    /* Hooks */
    import {useNavigate, useLocation} from "svelte-navigator";
    /* /Hooks */

    /* Store */
    import {user} from "../stores";
    /* /Store */

    const navigate = useNavigate();
    const location = useLocation();

    $: if (!$user) {
        navigate("/login", {
            state: {from: $location.pathname},
            replace: true,
        })
    }
</script>

{#if $user}
    <slot/>
{/if}
