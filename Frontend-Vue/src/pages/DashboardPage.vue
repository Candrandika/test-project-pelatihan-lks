<script setup>
    import MyFormComponent from '../components/MyFormComponent.vue';
    import MyResponseComponent from '../components/MyResponseComponent.vue';
</script>
<template>
    <div class="container">
        <MyFormComponent />
        <MyResponseComponent />
    </div>
</template>
<script>
export default {
    beforeCreate() {
        this.$emit('changePageTitle', 'Dashboard')
    },
}
</script>