<template>
    <Head><title>Profile</title></Head>
    <navigation-bar />
    <div class="container">
        <h1>{{ user.username }}</h1>
        <inertia-link v-if="user.id === $page.props.auth.user.id" :href="'/profile/update/' + user.username" class="btn btn-primary">Edit Profile</inertia-link>
        <hr>
    </div>
    <view-topics :topics="posts.data"></view-topics>
    <div v-if="posts.data < 1" class="empty-posts">
        <h4>There are no posts yet</h4>
    </div>
    <pagination class="container" :links="posts.links" @nextPage="getTopics($event)"></pagination>
    <Footer />
</template>

<script>
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/Footer";
import ViewTopics from "./viewTopics";
import Pagination from "../layout/pagination";
export default {
    name: "profile",
    props: {
        user: {
            required: true
        }
    },
    components: {
        NavigationBar,
        Footer,
        ViewTopics,
        Pagination
    },
    data() {
        return {
            posts: [],
        }
    },
    methods: {
        getTopics(site) {
            axios.get(site).then((response) => {
                this.posts = response.data;
            }).catch((error) => {
                console.log('Error: ' + error);
            });
        }
    },
    mounted() {
        this.getTopics(/view-profile-posts/ + this.user.id);
    }
};
</script>

<style scoped lang="sass">
.empty-posts
    height: 200px
    width: 80%
    background-color: #A9A9A9
    border-radius: 25px
    display: block
    margin: 0 auto
    h4
        display: grid
        text-align: center
        padding-top: 90px
</style>
