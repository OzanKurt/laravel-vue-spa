<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white navbar-custom">
        <div class="container">
            <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
                {{ appName }}
            </router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
                <span class="navbar-toggler-icon"/>
            </button>

            <div id="navbarToggler" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <locale-dropdown/>
                    <!-- Authenticated -->
                    <template v-if="user">
                        <li class="nav-item dropdown"
                            :class="{
                                'active': navbarDropdownActive,
                            }"
                            style="flex-direction: column;"
                        >
                            <a id="navbarDropdown" class="nav-link d-flex align-items-center justify-content-around"
                                href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="min-width: 200px; margin: auto;"
                            >
                                <img :src="user.photo_url" class="nav-profile-picture mr-2">
                                <span class="">
                                    {{ user.name }}
                                </span>
                                <fa icon="caret-down" size="2x" fixed-width/>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
                                style="width: 100%; margin-top: 0;"
                            >
                                <div class="dropdown-header">Settings</div>
                                <router-link class="dropdown-item f-sides"
                                    :to="{ name: 'settings.profile' }"
                                >
                                    Profile <fa icon="user" fixed-width/>
                                </router-link>
                                <router-link class="dropdown-item f-sides"
                                    :to="{ name: 'settings.security' }"
                                >
                                    Security <fa icon="lock" fixed-width/>
                                </router-link>
                                <router-link class="dropdown-item f-sides"
                                    :to="{ name: 'settings.preferences' }"
                                >
                                    Preferences <fa icon="cogs" fixed-width/>
                                </router-link>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item pl-3 f-sides" @click.prevent="logout">
                                    {{ $t('logout') }}
                                    <fa icon="sign-out-alt" fixed-width/>
                                </a>
                            </div>
                        </li>
                    </template>

                    <!-- Guest -->
                    <template v-else>
                        <router-link tag="li"
                            class="nav-item"
                            :to="{ name: 'auth.login' }"
                        >
                            <a class="nav-link">
                                {{ $t('Login') }}
                            </a>
                        </router-link>
                        <router-link tag="li"
                            class="nav-item"
                            :to="{ name: 'auth.register' }"
                        >
                            <a class="nav-link">
                                {{ $t('Register') }}
                            </a>
                        </router-link>
                    </template>
                </ul>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
    import { mapGetters } from 'vuex'
    import LocaleDropdown from './LocaleDropdown'

    export default {
        data() {
            return {
                appName: window.config.appName,
                navbarDropdownActive: false,
            }
        },
        computed: {
            ...mapGetters('auth', [
                'user',
            ]),
        },
        methods: {
            async logout () {
                await this.$store.dispatch('auth/logout')

                this.$router.push({ name: 'login' })
            }
        },
        watch: {
            $route (to, from) {
                this.navbarDropdownActive = ['settings.profile', 'settings.security', 'settings.preferences'].includes(to.name)
            },
        },
        components: {
            LocaleDropdown
        },
    }
</script>

<style scoped>
.profile-photo {
    width: 2rem;
    height: 2rem;
    margin: -.375rem 0;
}
</style>
