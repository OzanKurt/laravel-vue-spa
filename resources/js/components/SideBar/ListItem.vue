<template>
    <router-link tag="li"
        :to="{ name: routeName }"
        :class="[
            className,
            {disabled: disabled}
        ]"
    >
        <a href="#">
            <fa :icon="icon" fixed-width class="mr-2" /> {{ text }}
        </a>
    </router-link>
</template>

<script>
    export default {
        name: 'SideBarListItem',
        props: [
            'routeName',
            'icon',
            'text',
            'disabled',
        ],
        data() {
            return {
            };
        },
        computed: {
            className() {
                return this.routeName == this.$router.currentRoute ? 'active' : '';
            }
        }
    }
</script>
