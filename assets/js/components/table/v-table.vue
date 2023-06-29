<template>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Country</th>
      <th scope="col">Balance</th>
      <th scope="col" class="text-center">Players</th>
    </tr>
    </thead>
    <tbody>
      <vTableRow v-for="row in teams_data.records" :key="row.id" :row_data="row" />
    </tbody>
  </table>
  <div class="v-table__pagination">
    <div class="page"
         v-for="page in teams_data.total_pages"
         :key="page"
         :class="{'page__active': page === page_active}"
         @click="pageClick(page); page_active = page"
    >{{ page }}
    </div>
  </div>
</template>

<script>
import vTableRow from './v-table-row'
import {mapActions, mapGetters} from 'vuex'

export default {
  name: "v-table",
  props: {
    teams_data: {
      type: Object,
      default: () => {
        return {}
      }
    },
    page_active: {
      type: Number,
      default: () => {
        return 1;
      }
    }
  },
  components: {
    vTableRow
  },
  data: () => ({}),
  computed: {
    ...mapGetters([
      'TEAMS'
    ])
  },
  methods: {
    ...mapActions([
      'GET_TEAMS_FROM_API'
    ]),
    pageClick(page) {
      this.GET_TEAMS_FROM_API({page: page, per_page: this.teams_data.per_page})
    }
  },
}
</script>

<style>
.v-table {
  max-width: 1300px;
  margin: 0 auto;
}

.v-table__header {
  display: flex;
  justify-content: space-around;
  border-bottom: solid 1px #e7e7e7;
  margin-bottom: 5px;
  font-weight: bold;
  font-size: 1.2rem;
}

.v-table__header p {
  flex-basis: 25%;
  text-align: center;
}

.v-table__pagination {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin: 20px;
}

.page {
  padding: 8px;
  border: solid 1px #e7e7e7;
  cursor: pointer;
}

.page:hover, .page__active {
  background-color: #aeaeae;
  color: #fff;
}
</style>