<template>
  <div class="container align-items-center">
    <h1>Add Team</h1>
    <form id="add-team-form" @submit.prevent="processFormSubmit">
      <div class="form-group">
        <label class="label">Name</label>
        <input type="text" class="form-control" name="name" v-model="name" required />
      </div>

      <div class="form-group">
        <label class="label">Country</label>
        <input type="text" class="form-control" name="country" v-model="country" required />
      </div>

      <div class="form-group">
        <label class="label">Balance</label>
        <input type="number" step="0.01" class="form-control" name="balance" v-model="balance" required />
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Add team</button>
      </div>
    </form>
  </div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  data: () => ({
    name: '',
    country: '',
    balance: '',
    errors: {
      name: false,
      country: false,
      balance: false
    }
  }),
  methods: {
    ...mapActions([
      'ADD_TEAM'
    ]),
    processFormSubmit: function () {
      this.ADD_TEAM({
        name: this.name,
        country: this.country,
        balance: parseFloat(this.balance).toFixed(2),
      })
    }
  }
}
</script>