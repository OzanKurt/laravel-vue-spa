<template>
    <card :title="$t('your_info')">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="$t('info_updated')"/>

            <!-- Submit Button -->
            <div class="form-group row">
                <div class="col-md-9 ml-md-auto">
                    <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
                </div>
            </div>
        </form>
    </card>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        scrollToTop: false,

        metaInfo () {
            return { title: this.$t('settings') }
        },

        data: () => ({
            form: new Form({
                name: '',
                email: ''
            })
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        created () {
            this.form.keys().forEach(key => {
                this.form[key] = this.user[key]
            })
        },

        methods: {
            async update () {
                const { data } = await this.form.patch('/api/settings/preferences')

                this.$store.dispatch('auth/updateUser', { user: data })
            }
        }
    }
</script>
