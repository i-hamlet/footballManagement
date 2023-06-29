<template>
  <div class="container">
    <v-table :teams_data="TEAMS" />
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import vTable from '../components/table/v-table'

export default {
  components: {
    vTable
  },
  computed: {
    ...mapGetters([
        'TEAMS'
    ])
  },
  methods: {
    ...mapActions([
        'GET_TEAMS_FROM_API'
    ])
  },
  mounted() {
    this.GET_TEAMS_FROM_API()
  }
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
}
</style>