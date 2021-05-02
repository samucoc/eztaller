<template>
    <div>
        <router-view/>
        <v-overlay :value="loading" z-index="250">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
    </div>
</template>
<script>
    export default {
        name: 'App',
        computed: {
            loading() {
                return this.$store.getters.getLoading
            }
        }
    }
</script>