<template>
    <div class="container">
        <h3>Comments</h3>
        <page-loader v-if="!comments.data"/>
        <div v-if="comments.data < 1" class="empty-comments">
            <h4>There are no comments yet</h4>
        </div>
        <div v-if="comments.data" :key="comment.id"
            v-for="(comment, index) in comments.data">
            <hr>
            <p>{{ comment.comment }}</p>
            <div v-if="$page.props.auth.user.id === comment.user.id">
                <form @submit.prevent class="edit-form">
                    <textarea
                          class="form-control" rows="4" minlength="4">{{ comment.comment }}</textarea>
                </form>
                <div class="buttons">
                    <button id="update" class="btn btn-primary" @click="updateComment(index, $event)">Update Comment</button>
                    <button id="cancel" class="btn btn-primary" @click="cancelComment(index, $event)">Cancel</button>
                    <button id="edit" class="btn btn-primary" @click="openForm">Edit Comment</button>
                    <button id="delete" class="btn btn-danger" @click="deleteComment(index)">Delete Comment</button>
                </div>
            </div>
            <inertia-link :href="route('user.profile', comment.user.username)">
                {{ comment.user.username }}
            </inertia-link>
            <p>{{ this.formatDate(comment.created_at) }}</p>
        </div>
        <pagination v-if="comments.links" :links="comments.links" @nextPage="getComments($event)"></pagination>

        <div v-if="$page.props.auth.login">
            <form @submit.prevent>
                <label>Post a Comment</label>
                <textarea v-model="form.comment" class="form-control" rows="4" minlength="4"></textarea>
                <div v-if="form.errors.comment" class="alert-danger">{{ form.errors.comment }}</div>
                <button class="btn btn-primary" :disabled="Object.keys(form.comment).length < 4 || form.processing" v-on:click="setComment">Post Comment</button>
            </form>
        </div>
    </div>
</template>

<script>
import pageLoader from "./PageLoader.vue";
import { useForm } from "@inertiajs/vue3"
import Pagination from "../layout/pagination.vue";
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue';
import moment from "moment";
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
            _token : computed(() => usePage().props.csrf),
            post_id : this.id
        });
      return {
          comments: [],
          date: 0,
          disabled: Boolean,
          success: {},
          form,
          lastPaginationEvent: ''
      }
    },
    methods: {
        getComments(site) {
            this.lastPaginationEvent = site;
            this.comments = [];
            axios.get(site).then((response) => {
                this.comments = response.data;
            }).catch((error) => {
            console.log('Error: ' + error);
            });
        },
        setComment(){
           this.form.post(route('comment.store'), {
               onSuccess: () => {
                   this.getComments(this.lastPaginationEvent);
                   this.$swal({
                       title: 'Your comment has been posted!',
                       text: '',
                       icon: 'success',
                       timer: 3000
                   });
               }
           });
           this.form.comment = '';
        },
        cancelComment(index, event){
            event.target.parentElement.parentElement.childNodes[0].querySelector("textarea").value = this.comments.data[index].comment;
            this.closeForm(event);
        },
        updateComment(index, event){
            const form = event.target.parentElement.parentElement.childNodes[0];
            const comment = useForm({
                _token : this.$page.props.csrf,
                comment: form.querySelector("textarea").value
            });
            this.$inertia.put(`/comment/${this.comments.data[index].id}`, comment, {
                onSuccess: () => {
                    this.comments.data[index].comment = comment.comment;
                    this.closeForm(event);
                    this.$swal({
                        title: 'Your comment has been updated!',
                        text: '',
                        icon: 'success',
                        timer: 3000
                    });
                }
            });

        },
        deleteComment(index)
        {
            this.$swal({
                title: 'Are you sure you want to delete your comment?',
                text: 'Your comment will be gone forever!',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                dangerMode: true
            }).then((result) => {
                    if(result.isConfirmed){
                        this.$inertia.delete(`/comment/${this.comments.data[index].id}`, {
                            onSuccess: () => {
                                this.comments.data.splice(index);
                                this.$swal({
                                    title: 'Your comment has been Deleted!',
                                    text: '',
                                    icon: 'success',
                                    timer: 3000
                                });
                            }
                        });
                    }
                    else{
                        return false;
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
            button.childNodes[1].style.display = 'block';
            button.parentNode.firstElementChild.style.display = 'block';
            button.parentNode.parentNode.getElementsByTagName('p')[0].style.display = 'none';
        },
        closeForm(event)
        {
            const div = event.target.parentElement.parentElement;
            const buttons = div.getElementsByTagName('div')[0];
            div.getElementsByTagName('form')[0].style.display = 'none';  // hide edit form
            buttons.childNodes[0].style.display = 'none'; // hide update button
            buttons.childNodes[1].style.display = 'none'; // hide cancel button
            buttons.childNodes[2].style.display = 'block'; // show edit button
            event.target.parentNode.parentNode.parentNode.getElementsByTagName('p')[0].style.display = 'block'; // show updated text
        },
      formatDate(value)
      {
        return moment(String(value)).format('DD/MM/YYYY H:MM a')
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
#update
    display: none
#cancel
    display: none
.empty-comments
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
.buttons
    display: flex
    flex: 1
    justify-content: left
    button
        margin: 0 3px 0 0
</style>
