<template>
  <div id="app">
    <header class="app-header">
      <Nav />
      <Flash />
    </header>

    <div class="app-content">
      <main class="container">
        <router-view />
      </main>
    </div>

    <footer class="app-footer">
      <div class="container">
        <hr />
        <p>&copy; App. All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script>
  import Nav from './components/Nav.vue'
  import Flash from './components/Flash.vue'

  export default {
    name: "App",
    components: {
      Nav,
      Flash
    }
  }
</script>

<style src="./assets/styles/theme.scss" lang="scss" />
<style lang="scss">
  body {
    min-height: 100vh;
  }

  #app {
    min-height: 100vh;
    display: flex;
    flex-direction: column
  }

  .app-content {
    flex: 1;
    padding: 1rem 0;
  }
</style>
