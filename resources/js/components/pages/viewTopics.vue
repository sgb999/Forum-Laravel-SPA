<template>
    <Head><title>View Topics</title></Head>
    <div class="container">
        <page-loader  v-if="!topics"/>
        <div v-if="topics"
           v-for="topic in topics"
            class="grid">
            <inertia-link :href="route('post.show', topic.id)">
            <h3>{{topic.title}}</h3>
            </inertia-link>
            <inertia-link :href="route('profile', topic.user.username)">
                <p>{{topic.user.username}}</p>
            </inertia-link>
            <inertia-link :href="route('topics.show', topic.category.id)">
                <p>{{ topic.category.name }}</p>
            </inertia-link>
            <p>{{ topic.created_at }}</p>
        </div>
    </div>
</template>

<script>
import PageLoader from "./PageLoader";
export default {
    name: "viewTopics",
    components:{
      PageLoader
    },
    props:{
        topics: {
            type: [],
            required: false
        }
    }
};
</script>

<style lang="sass" scoped>
a, a:hover, a:focus, a:active
    text-decoration: none
    color: inherit
.container
    display: grid
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
    grid-column-gap: 10px
    .grid
        padding: 5px
        margin-bottom: 10px
        border: solid #000000
        border-radius: 25px
</style>
