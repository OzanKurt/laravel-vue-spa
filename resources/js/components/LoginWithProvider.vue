<template>
    <button class="btn btn-social-icon mx-1" type="button"
        v-if="onlyIcon"
        :class="{
            [btnClass]: true,
        }"
        @click="login"
    >
        <fa :icon="['fab', provider.name]" fixed-width/>
    </button>
    <button class="btn btn-social mx-1" type="button"
        v-else
        :class="{
            [btnClass]: true,
        }"
        @click="login"
    >
        <fa :icon="['fab', provider.name]" fixed-width/>
        {{ $t('login_with') }} {{ provider.display_name }}
    </button>
</template>

<script>
    export default {
        name: 'LoginWithProvider',
        props: {
            provider: Object,
            onlyIcon: Boolean,
        },
        computed: {
            url() {
                return `/api/oauth/${this.provider.name}`
            },
            btnClass() {
                // return `btn-facebook`
                return `btn-${this.provider.name}`
            },
        },
        mounted () {
            window.addEventListener('message', this.onMessage, false)
        },
        beforeDestroy () {
            window.removeEventListener('message', this.onMessage)
        },
        methods: {
            async login () {
                const newWindow = openWindow('', this.$t('login'))

                const url = await this.$store.dispatch('auth/fetchOauthUrl', {
                    provider: this.provider.name
                })

                newWindow.location.href = url
            },

            onMessage (e) {
                if (e.origin !== window.origin || !e.data.token) {
                    return
                }

                this.$store.dispatch('auth/saveToken', {
                    token: e.data.token
                })

                this.$router.push({ name: 'home' })
            }
        }
    }

    function openWindow (url, title, options = {}) {
        if (typeof url === 'object') {
            options = url
            url = ''
        }

        options = { url, title, width: 600, height: 720, ...options }

        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
        const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
        const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height

        options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
        options.top = ((height / 2) - (options.height / 2)) + dualScreenTop

        const optionsStr = Object.keys(options).reduce((acc, key) => {
            acc.push(`${key}=${options[key]}`)
            return acc
        }, []).join(',')

        const newWindow = window.open(url, title, optionsStr)

        if (window.focus) {
            newWindow.focus()
        }

        return newWindow
    }
</script>
