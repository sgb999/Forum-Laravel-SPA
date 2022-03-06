<template>
    <Head><title>Make a post</title></Head>
    <navigation-bar />
    <div class="container">
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
                    <textarea v-model="form.content" class="form-control" rows="4" required></textarea>
                    <div v-if="form.errors.content" class="alert-danger">{{ form.errors.content }}</div>
                </div>
                    <label>Category</label>
                <div class="form-group">
                    <select v-model="form.category_id" class="form-control-sm">
                        <option disabled value="">Please select one</option>
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

import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    name: "MakePost",
    components: {
      NavigationBar,
      Footer
    },
    props: {
      categories: {
          required: true
      }
    },
    data() {
        let form = useForm({
            title : '',
            content : '',
            category_id : '',
            _token : this.$page.props.csrf,
        });
        return {
            form
        }
    },
    methods: {
        post() {
            this.form.post(route('post.store'), {
                onSuccess: () => {
                    this.$swal({
                        title: 'Your post has been posted!',
                        text: '',
                        icon: 'success'
                    });
                }
            });
        }
    }
};
</script>

<style scoped>

</style>
