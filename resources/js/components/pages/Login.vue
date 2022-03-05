<template>
    <Head><title>Login</title></Head>
    <navigation-bar />
    <div class="container">
        <h1>Login to account</h1>
        <form @submit.prevent>
            <div class="form-group">
                <label>E-mail</label>
                <input v-model="form.email" class="form-control" type="email" placeholder="example@example.com" minlength="8" maxlength="255" required>
                <div v-if="form.errors.email" class="alert-danger">{{ form.errors.email }}</div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input v-model="form.password" class="form-control" type="password" placeholder="minimum 8 characters"  maxlength="255" required>
            </div>
            <p></p>
            <button class="btn btn-primary" :disabled="form.processing" v-on:click="login">Log in</button>
        </form>
    </div>
    <Footer />
</template>

<script>
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
import { useForm } from "@inertiajs/inertia-vue3"
export default {
    name: "Login",
    components: {
        NavigationBar,
        Footer
    },
    data() {
        let form = useForm({
            email : '',
            password : '',
            _token : this.$page.props.csrf,
        });
        return {
            errors: [],
            form
        }
    },
    methods: {
        login(){
            this.form.post('/login');
        }
    }
};
</script>

<style scoped>

</style>
