<template>
    <div class="row">
        <div class="col-md-3">
            <side-bar-card :header="$t('settings')" :is-open="true">
                <ul class="nav">
                    <side-bar-list-item
                        v-for="tab in tabs" :key="tab.route"
                        :icon="tab.icon"
                        :text="tab.name"
                        :route-name="tab.route"
                    />
                </ul>
            </side-bar-card>
        </div>


        <div class="col-md-9">
            <transition name="fade" mode="out-in">
                <router-view/>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        middleware: 'auth',
        computed: {
            tabs () {
                return [
                    {
                        icon: 'user',
                        name: this.$t('profile'),
                        route: 'settings.profile'
                    },
                    {
                        icon: 'lock',
                        name: this.$t('security'),
                        route: 'settings.security'
                    },
                    {
                        icon: 'cogs',
                        name: this.$t('preferences'),
                        route: 'settings.preferences'
                    }
                ]
            }
        }
    }
</script>

<style>
.settings-card .card-body {
    padding: 0;
}
</style>
