<template>
    <Head><title>Register</title></Head>
    <navigation-bar />
    <div class="container">
        <h1>Register an account</h1>
            <form @submit.prevent>
            <div class="form-group">
                <label>Name</label>
                <input class="form-control col-4 d-flex justify-content-center" type="text" v-model="form.name" placeholder="John Doe" maxlength="255" required>
                <div v-if="form.errors.name" class="alert-danger">{{ form.errors.name }}</div>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input class="form-control col-4 d-flex justify-content-center" type="text" v-model="form.username" placeholder="user123" maxlength="255" required>
                <div v-if="form.errors.username" class="alert-danger">{{ form.errors.username }}</div>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input class="form-control" type="email" v-model="form.email" placeholder="example@example.com" minlength="8" maxlength="255" required>
                <div v-if="form.errors.email" class="alert-danger">{{ form.errors.email }}</div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" v-model="form.password" placeholder="minimum 8 characters" minlength="8" maxlength="255" required>
                <div v-if="form.errors.password" class="alert-danger">{{ form.errors.password }}</div>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input class="form-control" type="password" v-model="form.password_confirmation" placeholder="Must match password" minlength="8" maxlength="255" required>
                <div v-if="form.errors.password_confirmation" class="alert-danger">{{ form.errors.password_confirmation }}</div>
            </div>
            <p></p>
            <button class="btn btn-primary" :disabled="form.processing" v-on:click="register">Register</button>
        </form>
    </div>
    <Footer />
</template>

<script>
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
import { useForm } from "@inertiajs/inertia-vue3"
export default {
    name: "Register",
    components: {
        NavigationBar,
        Footer
    },
    data() {
        let form = useForm({
            name : '',
            username : '',
            email : '',
            password : '',
            password_confirmation : '',
            _token : this.$page.props.csrf,
        });
        return {
            form
        }
    },
    methods: {
        register() {
            this.form.post('/register');
        }
    }
};
</script>

<style scoped>

</style>
