<template>
        <div id="nav" class="nav">
            <router-link to="/" class="brand">FrugalX</router-link>

      <nav>
            <router-link :to="{ name: 'home' }" class="nav-item">Home</router-link> |
            <router-link :to="{ name: 'marketplace' }" class="nav-item">Market Place</router-link>
      </nav>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 60px;
      box-sizing: border-box;
      width: 500px;
      padding: 0 20px 20px;
      margin: 0 auto;
    }
    .nav > .brand {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 1.5em;
      color: #8A2BE2;
      text-decoration: none;
    }
    .nav .nav-item {
      box-sizing: border-box;
      margin: 0 5px;
      color: rgba(0, 0, 0, 0.5);
      text-decoration: none;
    }
    .nav .nav-item.router-link-exact-active {
      color: #8A2BE2;
      border-bottom: solid 2px #8A2BE2;
    }

    @media only screen and (max-width: 600px) {
      .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 60px;
      box-sizing: border-box;
      width: 500px;
      padding: 0 20px 0px;
      margin: 0 auto;
    }
    .nav > .brand {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 1.5em;
      color: #8A2BE2;
      text-decoration: none;
    }
    .nav .nav-item {
      box-sizing: border-box;
      margin: 0 5px;
      color: rgba(0, 0, 0, 0.5);
      text-decoration: none;
    }
    .nav .nav-item.router-link-exact-active {
      color: #8A2BE2;
      border-bottom: solid 2px #8A2BE2;
    }
    }
</style>
