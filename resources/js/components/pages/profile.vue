<template>
    <Head title="Profile" />
    <navigation-bar />
    <img class="banner" :src="banner ? banner : '/storage/default/banner.jpg'" alt="banner">
    <div class="container">
        <div class="user">
            <img class="avatar" :src="avatar ? avatar : '/storage/default/avatar.png'" alt="avatar">
            <h1>{{ user.username }}</h1>
            <div class="right">
                <inertia-link v-if="user.id === $page.props.auth.user.id" :href="route('user.index', user.username)" class="btn btn-primary">Edit Profile</inertia-link>
                <inertia-link v-if="user.id !== $page.props.auth.user.id && $page.props.auth.login" :href="route('chat.show', user.id)" class="btn btn-primary">Message</inertia-link>
            </div>
        </div>
    </div>
    <div class="content">
        <hr class="container">
        <view-topics :topics="posts.data"></view-topics>
        <div v-if="posts.data < 1" class="empty-posts">
            <h4>There are no posts yet</h4>
        </div>
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
            banner: '',
            avatar: '',
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
        this.getTopics('/view-profile-posts/' + this.user.id);
        this.user.media.forEach(el => {
            if(el.collection_name === 'banner'){
                this.banner = el.original_url;
            }
            if(el.collection_name === 'avatar'){
                this.avatar = el.original_url;
            }
        })
    }
};
</script>

<style scoped lang="sass">
.banner
    position: absolute
    height: 600px
    width: 100%
    top: 100px
    bottom: 0
    left: 0
    right: 0
    box-sizing: border-box
.content
    padding-top: 700px
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

.user
    padding-top: 550px
    position: absolute
    display: flex
    flex: 1
    .avatar
        height: 150px
        width: 150px
        border-radius: 50%
        border: solid 2px #FFFFFF
        margin-right: 20px
        color: rgb(228, 230, 235)
    h1, .right
        margin-top: 50px
    .right
        margin-left: 50vw
</style>
