<template>
    <Head title="Chats" />
    <navigation-bar />
    <div class="container">
    <h1>Chats</h1>
    <hr>
    <div v-for="chat in chats">
        <inertia-link :href="route('chat.show', chat.id)">{{ chat.username }}</inertia-link>
    </div>
    </div>
    <Footer />
</template>

<script>
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/Footer";
export default {
    name: "chat",
    components: {
        NavigationBar,
        Footer
    },
    data(){
      return {
          chats: []
      }
    },
    methods: {
        getChats()
        {
            axios.get(route('chat.get-chats')).then((response) => {
                this.chats = response.data;
                console.log(this.chats);
            }).catch((error) => {
                console.log('Error: ' + error);
            });
        }
    },
    mounted(){
        this.getChats();
    }
};
</script>

<style scoped lang="sass">
a
    color: #000000
    text-decoration: none
    font-size: 20px
</style>
