<template>
    <div class="container">
        <h3 id="comment">Comments</h3>
        <page-loader v-if="!comments.data"/>
        <div v-if="comments.data" :key="comment.id"
            v-for="(comment, index) in comments.data">
            <hr>
            <p>{{ comment.comment }}</p>
            <div v-if="$page.props.auth.user.id === comment.user.id">
                <form @submit.prevent class="edit-form">
                    <div class="test"></div>
                    <textarea
                          class="form-control" rows="4" minlength="4">{{ comment.comment }}</textarea>

                </form>
                <div class="buttons">
                    <button id="update" class="btn btn-primary" @click="updateComment(index, $event)" style="display: none">Update Comment</button>
                    <button id="edit" class="btn btn-primary" @click="openForm">Edit Comment</button>
                    <button id="delete" class="btn btn-danger" @click="deleteComment(index)">Delete Comment</button>
                </div>
            </div>
            <inertia-link :href="'/profile/' + comment.user.username">
                {{ comment.user.username }}
            </inertia-link>
            <p>{{ comment.created_at }}</p>
        </div>
        <pagination v-if="comments.links > 3" :links="comments.links" @nextPage="getComments($event)"></pagination>
    </div>
        <div v-if="$page.props.auth" class="container">
            <form @submit.prevent>
                <label>Post a Comment</label>
                <textarea v-model="form.comment" class="form-control" rows="4" minlength="4"></textarea>
                <div v-if="form.errors.comment" class="alert-danger">{{ form.errors.comment }}</div>
                <button class="btn btn-primary" :disabled="Object.keys(form.comment).length < 4 || form.processing" v-on:click="setComment">Post Comment</button>
            </form>
        </div>
</template>

<script>
import pageLoader from "./PageLoader";
import { useForm } from "@inertiajs/inertia-vue3"
import Pagination from "../layout/pagination";
import { usePage } from '@inertiajs/inertia-vue3'
import { computed } from 'vue';
export default {
    name: "Comment",
    components:{
      pageLoader,
      Pagination
    },
    props:{
      id: {
          required: true
      }
    },
    data(){
        const form = useForm({
            comment : '',
            _token : computed(() => usePage().props.value.csrf),
            post_id : this.id
        });
      return {
          comments: [],
          date: 0,
          disabled: Boolean,
          success: {},
          form
      }
    },
    methods: {
        getComments(site) {
            this.comments = [];
            axios.get(site).then((response) => {
                this.comments = response.data;
            }).catch((error) => {
            console.log('Error: ' + error);
            });
        },
        setComment(){
           this.form.post('/comment');
           this.form.comment = '';
        },
        updateComment(index, event){
            const form = event.target.parentElement.parentElement.childNodes[0];
            const comment = {
                _token : this.$page.props.csrf,
                comment: form.querySelector("textarea").value
            };
            axios.put('/comment/' + this.comments.data[index].id, comment).then((response) => {
                if(response.status === 200)
                {
                    this.comments.data[index].comment = comment.comment;
                    this.closeForm(event);
                }
            }).catch(error => {
                if (error.response.data.errors) {
                    console.log(error.response.data.errors);
                }
            });
        },
        deleteComment(index)
        {
            axios.delete('/comment/' + this.comments.data[index].id).then((response) => {
                if(response.status === 200) {
                    this.comments.data.splice(index);
                }
            });
        },
        removeUnwantedChars()
        {
            for(let i = 0; i < this.comments.length; i++) {
                this.comments.created_at[i] = this.comments.created_at[i].split(".")[0];
            }
        },
        openForm(event)
        {
            const button = event.target.parentNode;
            event.target.closest('#edit').style.display = 'none';
            button.childNodes[0].style.display = 'block';
            button.parentNode.firstElementChild.style.display = 'block';
            button.parentNode.parentNode.getElementsByTagName('p')[0].style.display = 'none';
        },
        closeForm(event)
        {
            event.target.parentElement.parentElement.childNodes[0].style.display = 'none';  // hide edit form
            event.target.parentNode.parentNode.getElementsByTagName('button')[0].style.display = 'none'; // hide update button
            event.target.parentNode.parentNode.getElementsByTagName('button')[1].style.display = 'block'; // show edit button
            event.target.parentNode.parentNode.parentNode.getElementsByTagName('p')[0].style.display = 'block'; // show updated text
        }
    },
    mounted() {
        this.getComments('/comment/view/' + this.id);
    }
};
</script>

<style scoped lang="sass">
.form-control
    margin-bottom: 10px
a
    color: #000000
    text-decoration: none
.edit-form
    display: none
.buttons
    display: flex
    flex: 1
    justify-content: left
    button
        margin-right: 3px
</style>
