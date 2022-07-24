<template>
    <Head title="Message" />
    <navigation-bar />
    <div class="container">
        <div class="grid">
            <div v-for="message in messages">
                <hr>
                <div v-bind:class="(message.user.id === $page.props.auth.user.id)?'user': 'not-user'" class="message">
                    <p>{{ message.message }}</p>
                    <inertia-link :href="route('profile', message.user.username)">{{ message.user.username }}</inertia-link>
                </div>
            </div>
        </div>
        <hr>
        <form @submit.prevent>
            <label>Post a Comment</label>
            <div class="message">
                <textarea v-model="form.message" class="form-control" rows="4" minlength="4"></textarea>
                <button @click="sendMessage" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <Footer />
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import NavigationBar from "../layout/NavigationBar.vue";
import Footer from "../layout/Footer.vue";
export default {
    name: "message",
    components: {
        NavigationBar,
        Footer
    },
    props:{
        id:{
          required: true
        },
        messages: {
          required: false
        }
    },
    data(){
        const form = useForm({
            chat_id: this.id,
            message : '',
            _token : this.$page.props.csrf,
        });
        return {
            form,
            messages: []
        }
    },
    methods:{
        getChats(){
            axios.get(route('message.index', this.id)).then((response) => {
                this.messages = response.data;
            }).catch((error) => {
                console.log('Error: ' + error)
            });
        },
        sendMessage(){
            this.form.post(route('message.store'), {
                onSuccess: () => {
                    this.form.message = '';
                }
            })
        }
    },
    mounted() {
        window.setInterval(() => {
            this.getChats()
        }, 1000);
    }
};
</script>

<style scoped lang="sass">
a
    text-decoration: none
    color: #000000
.message
    button
        margin-top: 25px
        height: 40px
        margin-left: 10px
</style>
