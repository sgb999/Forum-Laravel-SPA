<template>
    <Head><title>Update Post</title></Head>
    <navigation-bar />
    <div class="container">
        <p>{{ post.id }}</p>
        <div class="row">
            <h2 class="col">Make a Post</h2>
            <form @submit.prevent>
                <div class="form-group">
                    <label>Post Title</label>
                    <input v-model="form.title" class="form-control">
                    <div v-if="form.errors.title" class="alert-danger">{{ form.errors.title }}</div>
                </div>
                <div class="form-group">
                    <label>Post Content</label>
                    <textarea v-model="form.content" class="form-control" rows="4" required>{{ post.content }}</textarea>
                    <div v-if="form.errors.content" class="alert-danger">{{ form.errors.content }}</div>
                </div>
                <label>Category</label>
                <div class="form-group">
                    <select v-model="form.category_id" class="form-control-sm">
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                    <div v-if="form.errors.category_id" class="alert-danger">{{ form.errors.category_id }}</div>
                </div>

                <p></p>
                <button :disabled="form.processing" @click="post" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>
    <Footer />
</template>

<script>
import navigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    name: "updatePost",
    components: {
        navigationBar,
        Footer
    },
    props: {
      post: {
            required: true
        },
      categories :{
          required: true
      }
    },
    data(){
        let form = useForm({
            id: this.post.id,
            title : this.post.title,
            content :  this.post.content,
            category_id : this.post.category_id,
            _token : this.$page.props.csrf,
        });
        return{
            form
        }
    },
    methods: {
        post() {
            this.form.put('/post/');
        }
    }
};
</script>

<style scoped>

</style>
