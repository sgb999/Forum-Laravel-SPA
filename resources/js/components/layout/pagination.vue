<template>
    <nav>
        <ul class="pagination">
            <li class="page-item" v-for="link in links"><button v-if="link.url" @click="$emit('nextPage', link.url)" :class="{'page-link' :  link.url, 'font-bold' : link.active}">{{ link.label}}</button></li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "pagination",
    props: {
        links: {
            type: [],
            required: true
        }
    }
};
</script>

<style scoped>

</style>
