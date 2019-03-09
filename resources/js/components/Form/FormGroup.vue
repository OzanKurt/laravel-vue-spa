<template>
    <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t(label) }}</label>
        <div class="col-md-7">
            <input
                type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.has(name) }"
                v-model="form[name]"
                :name="name"
            >
            <has-error :form="form" :field="name"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormGroup',
        props: ['label', 'name', 'form'],
    }
</script>
