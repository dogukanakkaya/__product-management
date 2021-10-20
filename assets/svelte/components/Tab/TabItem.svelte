<script>
    export let active = false
</script>

<li class={`cursor-pointer py-4 mr-6 border-b-2 ${active ? 'border-gray-900' : 'border-transparent'}`} on:click>
    <slot/>
</li>