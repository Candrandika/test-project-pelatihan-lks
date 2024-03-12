<template>
    <!-- S: Header -->
    <header class="jumbotron">
        <div class="container text-center">
            <h1 class="display-4">{{ title }}</h1>
        </div>
    </header>
    <!-- E: Header -->
</template>

<script>
    export default {
        props: ['title']
    }
</script>