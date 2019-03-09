<template>
    <div class="card">
        <div class="card-header">
            {{ $t('Profile') }}
        </div>
        <div class="card-body">
            <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                <alert-success :form="form" :message="$t('info_updated')"/>

                <form-group label="Name" name="name" :form="form" />

                <form-group label="Email" name="email" :form="form" />

                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-md-9 ml-md-auto">
                        <button type="submit" class="btn btn-primary"
                            :disabled="form.busy"
                        >
                            {{ $t('Update') }}
                        </button>
                        <button type="button" class="btn btn-link"
                            @click="test"
                            :disabled="form.busy"
                        >
                            {{ $t('Reset Changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        scrollToTop: false,
        metaInfo () {
            return { title: this.$t('settings') }
        },
        data() {
            return {
                form: null,
            }
        },
        computed: {
            ...mapGetters('auth', [
                'user'
            ]),
        },
        created () {
            this.form = new Form({
                name: this.user.name,
                email: this.user.email,
            })
        },
        methods: {
            test() {
                console.log('click')
                this.form.reset()
            },
            async update () {
                const { data } = await this.form.patch('/api/settings/profile')

                console.log(data)

                this.$store.dispatch('auth/updateUser', { user: data })
            }
        }
    }
</script>
