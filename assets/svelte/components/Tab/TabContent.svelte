<script>
    export let active = false
</script>

<div class:hidden={!active}>
    <slot/>
</div>