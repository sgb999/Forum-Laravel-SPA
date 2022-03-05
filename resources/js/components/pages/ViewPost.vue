<template>
    <Head><title>View Post</title></Head>
    <navigation-bar />
    <div class="container">
        <h3>{{post.title}}</h3>
        <p>{{post.content}}</p>
        <inertia-link :href="'/profile/' + post.user.username">
            {{post.user.username}}
        </inertia-link>
        <p>{{ post.created_at.split("T")[0] }}</p>
        <div class="row" v-if="post.user.id === $page.props.auth.user.id">
            <inertia-link :href="'/post/update/' + post.id" class="btn btn-primary col-1 btn-style">Edit</inertia-link>
            <form @submit.prevent>
                <button class="btn btn-danger" @click="deletePost">Delete</button>
            </form>
        </div>
        <hr>
    </div>
    <comment :id="post.id"/>
    <Footer />
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
import Comment from "./Comment";
export default {
    name: "ViewPost",
    props:{
        post: {
            required: true
        }
    },
    components: {
        NavigationBar,
        Footer,
        Comment
    },
    data(){
        let form = useForm({
            _token : this.$page.props.csrf
        });
        return{
            form
        }
    },
    methods: {
      deletePost(){
          this.form.delete('/post/' + this.post.id)
      }
    },
    mounted(){
        this.post.created_at = this.post.created_at.split(".")[0];
        //this.csrfToken = document.getElementsByTagName("META")['csrf-token']['content'];
    }
};
</script>

<style scoped lang="sass">
a
    color: #000000
    text-decoration: none
hr
    font-weight: bold
.btn-style
    color: #ffffff
</style>
