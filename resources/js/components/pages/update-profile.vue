<template>
    <navigation-bar />
    <div class="container">
        <img class="banner" v-if="banner" :src="banner" alt="banner">
        <img class="banner" v-if="!banner" src="/storage/default/banner.jpg" alt="banner">
        <div class="container">
            <div class="user">
                <img class="avatar" v-if="avatar" :src="avatar" alt="avatar">
                <img class="avatar" v-if="!avatar" src="/storage/default/avatar.png" alt="avatar">
                <h1 id="name-tag">{{ user.name }}</h1>
                <h1 id="username-tag">{{ user.username }}</h1>
                <h1 id="email-tag">{{ user.email }}</h1>
            </div>
        </div>
        <form @submit.prevent>
            <hr />
            <div class="row">
                <label for="name">Profile Banner</label>
                <div class="col">
            <file-pond
                name="banner"
                ref="pond"
                label-idle="Drop image here..."
                v-bind:allow-multiple="false"
                accepted-file-types="image/jpeg, image/png"
                :required="false"
                :server="{
                           url: '/tmp/image',
                           headers: {
                               'X-CSRF-TOKEN': $page.props.csrf
                           }
                    }"
                @processfile="profileBanner"
                @removefile="profileBanner"
            />
                </div>
                <div class="col">
                    <button class="btn btn-primary" :disabled="form.banner === ''" @click="updateProfileBanner">Update Profile Banner</button>
                </div>
            </div>
            <div class="row">
                <label for="name">Profile Picture</label>
                <div class="col">
            <file-pond
                name="avatar"
                ref="pond"
                label-idle="Drop image here..."
                v-bind:allow-multiple="false"
                :required="false"
                accepted-file-types="image/jpeg, image/png"
                :server="{
                           url: '/tmp/image',
                           headers: {
                               'X-CSRF-TOKEN': $page.props.csrf
                           }
                    }"
                @processfile="profilePicture"
                @removefile="profilePicture"
            />
                </div>
                <div class="col">
                    <button class="btn btn-primary" :disabled="form.avatar === ''" @click="updateProfilePicture">Update Profile Picture</button>
                </div>
            </div>
        <div class="row">
            <label for="name">Name</label>
            <div class="col">
                <input v-model="form.name" id="name" class="form-control col-4 d-flex justify-content-center" type="text"
                       placeholder="John Doe"  maxlength="255"
                       autocomplete="off">
                <div v-if="form.errors.name" class="alert-danger">
                    <ul>
                        <li>{{ form.errors.email }}</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.name === ''" @click="updateName">Update Name</button>
            </div>
        </div>
        <div class="row">
            <label for="username">Username</label>
            <div class="col">
                <input id="username" class="form-control col-4 d-flex justify-content-center" type="text"
                       v-model="form.username" placeholder="user123" maxlength="255" autocomplete="off">
                <div v-if="form.errors.username" class="alert-danger">
                    <ul>
                        <li>{{ form.errors.email }}</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <button @click="updateUsername" class="btn btn-primary" :disabled="form.username === ''">Update username</button>
            </div>
        </div>
        <div class="row">
            <label for="email">Email</label>
            <div class="col">
                <input v-model="form.email" id="email" class="form-control col-4 d-flex justify-content-center" type="text"
                        placeholder="example@example.com" maxlength="255" autocomplete="off">
                <div v-if="form.errors.email" class="alert-danger">
                    <ul>
                        <li>{{ form.errors.email }}</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.email === ''" @click="updateEmail">Update E-mail Address</button>
            </div>
        </div>
        <div class="row">
            <label for="password">Password</label>
            <div class="col">
                <input v-model="form.password" id="password" class="form-control col-4 d-flex justify-content-center" type="text"
                       placeholder="Password: Minimum 8 characters" minlength="8" maxlength="255"
                       autocomplete="off">
                <div v-if="form.errors.password" class="alert-danger">
                    <ul>
                        <li>{{ form.errors.password }}</li>
                    </ul>
                </div>
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
                <div v-if="form.errors.password_confirmation" class="alert-danger">
                    <ul>
                        <li>{{ form.errors.password_confirmation }}</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary" :disabled="form.password === '' || form.password_confirmation === ''" @click="updatePassword">Update Password</button>
            </div>
        </div>
            <button id="delete-button" class="btn btn-danger" @click="deleteProfile">Delete Profile</button>
        </form>
    </div>
    <Footer />
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
import { useForm } from "@inertiajs/inertia-vue3";

import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);
export default {
    name: "update-profile",
    components: {
        NavigationBar,
        Footer,
        FilePond
    },
    props: {
        user: {
            required: true
        }
    },
    data(){
        let form = useForm ({
            banner: '',
            avatar: '',
            name: '',
            username: '',
            email: '',
            password: '',
            password_confirmation: ''
        });
         return{
             banner: '',
             avatar: '',
             form
         }
    },
    methods:{
        updateName(){
            const object = {
                name : this.form.name
            }
            this.update(object, 'name')
        },
        updateUsername(){
            const object = {
                username : this.form.username
            }
            this.update(object, 'username')
        },
        updateEmail(){
            const object = {
                email : this.form.password
            }
            this.update(object, 'email')
        },
        updatePassword(){
            const object = {
                password : this.form.password,
                password_confirmation: this.form.password_confirmation,
            }
            this.update(object, 'password')
        },
        update(object, attribute)
        {
            object._token = this.$page.props.csrf;
            this.$inertia.put(route('user.edit', this.user.id), object,{
                onSuccess: () => {
                    switch(attribute){
                        case 'name':
                            this.user.name = this.form.name;
                            this.form.name = '';
                            break;
                        case 'username':
                            this.user.username = this.form.username;
                            this.form.username = '';
                            break;
                        case 'email':
                            this.user.email = this.form.email;
                            this.form.email = '';
                            break;
                        case 'password':
                            this.form.password = '';
                            this.form.password_confirmation = '';
                            break;
                        case 'profile picture':
                            document.getElementsByName("avatar")[0].value = '';
                            this.form.avatar = '';
                            break;
                        case 'profile banner':
                            document.getElementsByName("banner")[0].value = '';
                            this.form.banner = '';
                    }
                    this.sweetAlertSuccess(attribute); // fire success message
                },
                onError: () => {
                    this.$swal({
                        title: 'Ooops, something went wrong',
                        text: '',
                        icon: 'error',
                        timer: 3000
                    });
                }
            });
        },
        updateProfilePicture() {
            const object = {
                avatar : this.form.avatar
            }
            this.update(object, 'profile picture');
            axios.get('/user/' + this.user.id).then(resp => {
                resp.data.media.forEach(el => {
                    if(el.collection_name === 'avatar'){
                        this.avatar = el.original_url;
                    }

                })
            });
        },
        updateProfileBanner() {
            const object = {
                banner : this.form.banner,
            };
            this.update(object, 'profile banner');
            axios.get('/user/' + this.user.id).then(resp => {
                resp.data.media.forEach(el => {
                    if(el.collection_name === 'banner'){
                        this.banner = el.original_url;
                    }

                })
            });
        },
        profilePicture(){
            this.form.avatar = document.getElementsByName("avatar")[0].value;
        },
        profileBanner(){
            this.form.banner = document.getElementsByName("banner")[0].value;
        },
        deleteProfile() {
            this.$swal({
                title: 'Are you sure you want to delete your profile?',
                text: 'This cannot be undone!',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                dangerMode: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(route('user.destroy', this.user.id));
                } else {
                    return false;
                }
            });
        },
        sweetAlertSuccess(message)
        {
            this.$swal({
                title: 'Your ' + message + ' has been updated!',
                text: '',
                icon: 'success',
                timer: 3000
            });
        }
    },
    mounted() {
        this.user.media.forEach(el => {
            if(el.collection_name === 'banner'){
                this.banner = el.original_url;
            }
            if(el.collection_name === 'avatar'){
                this.avatar = el.original_url;
            }
        })
    }
};
</script>

<style scoped lang="sass">
#delete-button
    display: block
    margin: 20px auto 0
.banner
    position: absolute
    height: 600px
    width: 100%
    top: 100px
    bottom: 0
    left: 0
    right: 0
    box-sizing: border-box
.user
    padding-top: 550px
    position: absolute
    display: grid
    grid-template-columns: 20% 80%
    grid-template-rows: 35px 30px 30px
    .avatar
        grid-column: 1/1
        height: 150px
        width: 150px
        border-radius: 50%
        border: solid 2px #FFFFFF
        margin-right: 20px
        color: rgb(228, 230, 235)
    #name-tag
        margin-left: 100px
        margin-top: 25px
        margin-bottom: 0
        grid-column: 2/2
        grid-row: 1
    #username-tag
        margin-left: 100px
        grid-column: 2/2
        grid-row: 2
        margin-top: 20px
    #email-tag
        margin-left: 100px
        grid-column: 2/2
        grid-row: 3
        margin-top: 25px
form
    padding-top: 700px
</style>
