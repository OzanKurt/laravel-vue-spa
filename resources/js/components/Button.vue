<template>
    <button :type="nativeType" :disabled="loading" :class="{
        [`btn-${type}`]: true,
        [`btn-${size}`]: size != null,
        'btn-block': block,
        'btn-loading': loading,
    }" class="btn">
        <slot/>
    </button>
</template>

<script>
    export default {
        name: 'VButton',
        props: {
            type: {
                type: String,
                default: 'primary'
            },
            nativeType: {
                type: String,
                default: 'button'
            },
            loading: {
                type: Boolean,
                default: false
            },
            block: {
                type: Boolean,
                default: false
            },
            size: {
                size: String,
                default: null
            }
        }
    }
</script>
