<template>
    <Head title="View Post" />
    <navigation-bar />
    <div class="container">
        <h3>{{post.title}}</h3>
        <p>{{post.content}}</p>
        <inertia-link :href="'/profile/' + post.user.username">
            {{post.user.username}}
        </inertia-link>
        <p>{{ post.created_at.split("T")[0] }}</p>
        <div v-if="post.user.id === $page.props.auth.user.id">
            <inertia-link :href="route('post.edit', post.id)" id="edit" class="btn btn-primary col-1 btn-style">Edit</inertia-link>
            <button class="btn btn-danger" @click="deletePost">Delete</button>
        </div>
        <hr>
    </div>
    <comment :id="post.id"/>
    <Footer />
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/Footer";
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
          this.$swal({
              title: 'Are you sure you want to delete your post?',
              text: 'Your post will be gone forever!',
              icon: 'warning',
              showConfirmButton: true,
              showCancelButton: true,
              dangerMode: true
          }).then((result) => {
              if(result.isConfirmed){
                  this.form.delete(route('post.destroy', this.post.id));
              }
              else{
                  return false;
              }
          });
      }
    },
    mounted(){
        //this.post.created_at = this.post.created_at.split(".")[0];
        //this.csrfToken = document.getElementsByTagName("META")['csrf-token']['content'];
    }
};
</script>

<style scoped lang="sass">
a
    color: #000000
    text-decoration: none
    margin-right: 3px
hr
    font-weight: bold
.btn-style
    color: #ffffff
#edit
    width: 70px
</style>
