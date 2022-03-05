<template>
    <Head><title>Profile</title></Head>
    <navigation-bar />
    <div class="container">
        <h1>{{ user.username }}</h1>
        <inertia-link v-if="user.id === $page.props.auth.user.id" :href="'/profile/update/' + user.username" class="btn btn-primary">Edit Profile</inertia-link>
        <hr>
    </div>
    <view-topics :topics="posts.data"></view-topics>
    <pagination class="container" v-if="posts.links" :links="posts.links" @nextPage="getTopics($event)"></pagination>
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

<style scoped>

</style>
