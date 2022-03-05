<template>
    <h1 id="header">Assassin's creed forum</h1>
    <ul class="topnav">
        <li><inertia-link href="/">Home</inertia-link></li>
        <li><inertia-link href="/categories">View Categories</inertia-link></li>
        <li v-if="user" class="right"><inertia-link href="/log-out"><span class="glyphicon glyphicon-log-out red"></span> Sign out</inertia-link></li>
        <li v-if="user" class="right"><inertia-link href="#"><span class="glyphicon glyphicon-envelope yellow"></span>Messages</inertia-link></li>
        <li v-if="!user" class="right"><inertia-link href="/register"><span class="glyphicon glyphicon-user green"></span>Sign Up</inertia-link></li>
        <li v-if="!user" class="right"><inertia-link href="/login"><span class="glyphicon glyphicon-log-in green"></span>Login</inertia-link></li>
    </ul>
</template>

<script>
export default {
    name: "NavigationBar",
    computed: {
        user() {
            return this.$page.props.auth.login;
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
