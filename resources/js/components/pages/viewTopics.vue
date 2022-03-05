<template>
    <Head><title>View Topics</title></Head>
    <div class="container">
        <page-loader  v-if="!topics"/>
        <div v-if="topics"
           v-for="topic in topics">
            <inertia-link :href="'/view-post/' + topic.id">
            <h3>{{topic.title}}</h3>
            </inertia-link>
            <inertia-link :href="'/profile/' + topic.user.username">
                <p>{{topic.user.username}}</p>
            </inertia-link>
            <inertia-link :href="'/view-topics/' + topic.category.id">
                <p>{{ topic.category.name }}</p>
            </inertia-link>
            <p>{{ topic.created_at }}</p>
            <hr>
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
</style>
