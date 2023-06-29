<template>
  <tr>
    <th scope="row">{{ row_data.id }}</th>
    <td>{{ row_data.name }}</td>
    <td>{{ row_data.country }}</td>
    <td>{{ row_data.balance }}</td>
    <td>
      <div class="players_item" v-for="player in row_data.players">#{{ player.id }} | {{ player.firstName }} {{ player.lastName }}</div>
    </td>
  </tr>
</template>

<script>
export default {
  name: "v-table__row",
  props: {
    row_data: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {}
  },
  computed: {}
}
</script>

<style>
.v-table__row {
  display: flex;
  justify-content: space-around;
  border-bottom: solid 1px #e7e7e7;
}

.row {
  text-align: center;
  padding: 8px 16px;
  flex-basis: 25%;
}

.players_item {
  background: #e7e7e7;
  padding: 3px 12px;
  margin: 2px;
  display: inline-block;
  border-radius: 30px;
  font-size: 12px;
}
</style>