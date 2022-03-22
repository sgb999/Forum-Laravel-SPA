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
    grid-column-gap: 20px
    grid-row-gap: 15px
    height: fit-content
    .grid
        padding: 20px
        margin-bottom: 10px
        background-color: lightgray
        border-radius: 25px
        box-shadow: rgba(17, 17, 26, 0.1) 0 4px 16px, rgba(17, 17, 26, 0.1) 0 8px 24px, rgba(17, 17, 26, 0.1) 0 16px 24px
        animation: posts-load running 500ms
        transition: transform 0.8s
    .grid:hover
        transform: scale(1.2)

    @keyframes posts-load
        0%
            transform: translateX(-100%)
        100%
            transform: translateX(0)
@media screen and (max-width: 600px)
    .container
        .grid:hover
            transform: none
</style>
