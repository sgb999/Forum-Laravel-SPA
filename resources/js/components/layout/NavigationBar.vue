<template>
    <h1 id="header">Assassin's creed forum</h1>
    <ul class="topnav">
        <li><inertia-link :href="route('home')">Home</inertia-link></li>
        <li><inertia-link :href="route('categories.index')">View Categories</inertia-link></li>
        <li v-if="user" class="right"><inertia-link :href="route('log-out')"><span class="glyphicon glyphicon-log-out red"></span> Sign out</inertia-link></li>
        <li v-if="user" class="right"><inertia-link :href="route('chat.index')"><span class="glyphicon glyphicon-envelope yellow"></span>Messages</inertia-link></li>
        <li v-if="user" class="right"><inertia-link :href="route('profile', username)">Profile</inertia-link></li>
        <li v-if="!user" class="right"><inertia-link :href="route('register.index')"><span class="glyphicon glyphicon-user green"></span>Sign Up</inertia-link></li>
        <li v-if="!user" class="right"><inertia-link :href="route('login.index')"><span class="glyphicon glyphicon-log-in green"></span>Login</inertia-link></li>
    </ul>
</template>
<script>
export default {
    name: "NavigationBar",
    computed: {
        user() {
            return this.$page.props.auth.login;
        },
        username(){
            return this.$page.props.auth.user.username;
        }
    }
};
</script>

<style scoped>
body {
    margin: 0;
}
ul.topnav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

ul.topnav li {float: left;}

ul.topnav li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
.dropdown {
    float: left;
    overflow: hidden;
}

.dropdown .dropbtn {
    font-size: 16px;
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
    background-color: red;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}
#header {
    text-align: center;
}
ul.topnav li a:hover:not(.active) {background-color: #111;}

ul.topnav li a.active {background-color: #04AA6D;}

ul.topnav li.right {float: right;}

@media screen and (max-width: 600px) {
    ul.topnav li.right,
    ul.topnav li {float: none;}
}
</style>
