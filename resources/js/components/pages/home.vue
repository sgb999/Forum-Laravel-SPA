<template>
    <Head><title>Home</title></Head>
    <navigation-bar />
    <div class="container">
        <h3>Welcome to the Assassin's creed forum</h3>
        <p>This is a forum for the Assassin's creed game franchise</p>
        <p>Game developer: Ubisoft</p>
        <p>There are currently 1 Assassin's creed games released <i>(not including mobile)</i>, they are the following:</p>
        <ol><li>Assassin's Creed</li>
            <li>Assassin's Creed 2</li>
            <li>Assassin's Creed: Brotherhood</li>
            <li>Assassin's Creed: Revelations</li>
            <li>Assassin's Creed 3</li>
            <li>Assassin's Creed IV: Black Flag</li>
            <li>Assassin's creed: Rogue</li>
            <li>Assassin's Creed: unity</li>
            <li>Assassin's Creed: Syndicate</li>
            <li>Assassin's Creed: Origins</li>
            <li>Assassin's creed: Odyssey</li>
            <li>Assassin's creed: Valhalla</li>
        </ol>
    </div>
    <Footer />
</template>

<script>
import NavigationBar from "../layout/NavigationBar";
import Footer from "../layout/footer";
export default {
    name: "home",
    components:{
        NavigationBar,
        Footer
    }
};
</script>

<style scoped>

</style>
