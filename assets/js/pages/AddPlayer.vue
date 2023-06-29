<template>
  <div class="container align-items-center">
    <h1>Add Player</h1>
    <form id="add-player-form" @submit.prevent="processFormSubmit">
      <div class="form-group">
        <label class="label">Team ID</label>
        <input type="number" class="form-control input-number" name="teamId" v-model="teamId" required />
      </div>
      <div class="form-group">
        <label class="label">First name</label>
        <input type="text" class="form-control" name="firstName" v-model="firstName" required />
      </div>

      <div class="form-group">
        <label class="label">Last name</label>
        <input type="text" class="form-control" name="lastName" v-model="lastName" required />
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Add player</button>
      </div>
    </form>
  </div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  data: () => ({
    teamId: '',
    firstName: '',
    lastName: '',
    errors: {
      name: false,
      country: false,
      balance: false
    }
  }),
  methods: {
    ...mapActions([
      'ADD_PLAYER'
    ]),
    processFormSubmit: function () {
      this.ADD_PLAYER({
        teamId: this.teamId,
        firstName: this.firstName,
        lastName: this.lastName,
      })
    }
  }
}
</script>

<style>
.input-number::-webkit-outer-spin-button,
.input-number::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.input-number {
  -moz-appearance: textfield;
}
</style>