<template>
  <vNav />
  <router-view></router-view>
</template>

<script>
import vNav from './components/v-nav'

export default {
  components: {
    vNav
  }
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
}
</style>