<template>
    <navigation-bar />
    <div class="container">
        <h1>Update Account Details</h1>
        <h4>Name: {{ user.name }}</h4>
        <h4>Username: {{ user.username }}</h4>
        <h4>E-mail: {{ user.email }}</h4>
        <hr>
        <form @submit.prevent>
        <div class="row">
            <label for="name">Name</label>
            <div class="col">
                <input v-model="form.name" id="name" class="form-control col-4 d-flex justify-content-center" type="text"
                       placeholder="John Doe"  maxlength="255"
                       autocomplete="off">
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.name === ''" @click="setName">Update Name</button>
            </div>
        </div>
        <div class="row">
            <label for="username">Username</label>
            <div class="col">
                <input id="username" class="form-control col-4 d-flex justify-content-center" type="text"
                       v-model="form.username" placeholder="user123" maxlength="255" autocomplete="off">
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.username === ''">Update username</button>
            </div>
        </div>
        <div class="row">
            <label for="email">Email</label>
            <div class="col">
                <input v-model="form.email" id="email" class="form-control col-4 d-flex justify-content-center" type="text"
                        placeholder="example@example.com" maxlength="255" autocomplete="off">
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.email === ''" @click="setEmail">Update E-mail Address</button>
            </div>
        </div>
        <div class="row">
            <label for="password">Password</label>
            <div class="col">
                <input v-model="form.password" id="password" class="form-control col-4 d-flex justify-content-center" type="text"
                       placeholder="Password: Minimum 8 characters" minlength="8" maxlength="255"
                       autocomplete="off">
            </div>
            <div class="col">
            </div>
        </div>
        <div class="row">
            <label for="password_confirmation">Confirm Password</label>
            <div class="col">
                <input id="password_confirmation" class="form-control col-4 d-flex justify-content-center"
                       type="text" v-model="form.password_confirmation" placeholder="Must match Password"
                       maxlength="255" autocomplete="off">
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.password !== form.password_confirmation || form.password === ''" @click="setPassword">Update Password</button>
            </div>
        </div>
        <button class="btn btn-danger">Delete Profile</button>
        </form>
    </div>
    <Footer />
</template>

<script>
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
export default {
    name: "update-profile",
    components: {
        NavigationBar,
        Footer
    },
    props: {
        user: {
            required: true
        }
    },
    data(){
         return{
             form: {
                 name: '',
                 username: '',
                 email: '',
                 password: '',
                 password_confirmation: ''
             }
         }
    },
    methods:{
        setName()
        {
            const object = {
                _token : this.$page.props.csrf,
                name: this.form.name
            };
            if(axios.put('/profile/update/' + this.user.id, object).then((response) => {
                return response.status === 200;
            })){
                this.user.name = this.form.name;
            }
        },
        setUsername()
        {
            const object = {
                _token : this.$page.props.csrf,
                username: this.username
            };
            if(axios.put('/profile/update/' + this.user.id, object).then((response) => {
                return response.status === 200;
            })){
                this.user.username = this.form.username;
            }
        },
        setEmail()
        {
            const object = {
                _token : this.$page.props.csrf,
                email: this.email
            };
            if(axios.put('/profile/update/' + this.user.id, object).then((response) => {
                console.log(response);
                return response.status === 200;
            })){
                this.user.email = this.form.email;
            }
        },
        setPassword()
        {
            const object = {
                _token : this.$page.props.csrf,
                password: this.password,
                password_confirmation: this.password_confirmation
            };
            axios.put('/profile/update/' + this.user.id, object).then((response) => {
                return response.status === 200;
            });
        }
    }
};
</script>

<style scoped>

</style>
