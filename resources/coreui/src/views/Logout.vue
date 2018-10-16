<template>

</template>

<script>
    import store from '../../../assets/js/store'
    export default {
        mounted () {
            localStorage.removeItem('token')
            store.commit('logoutUser')
            this.$router.push({ name: 'login' })
        }
    }
</script>