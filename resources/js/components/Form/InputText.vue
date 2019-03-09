<template>
    <input type="text" class="form-control" :class="{
            'is-invalid': form.errors.has(this.name),
        }"
        :placeholder="placeholder || "
    >
</template>

<script>
    export default {
        name: 'InputText',
        props: {
            name: String,
            form: Object,
            placeholder: null,
        }
    }
</script>
