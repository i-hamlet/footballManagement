<template>
  <div class="container align-items-center">
    <h1>Transfers</h1>
    <form id="add-player-form" @submit.prevent="processFormSubmit">
      <div class="form-group">
        <label class="label">Seller ID</label>
        <input type="number" class="form-control input-number" name="sellerId" v-model="sellerId" required />
      </div>
      <div class="form-group">
        <label class="label">Buyer ID</label>
        <input type="number" class="form-control input-number" name="buyerId" v-model="buyerId" required />
      </div>
      <div class="form-group">
        <label class="label">Player ID</label>
        <input type="number" class="form-control input-number" name="playerId" v-model="playerId" required />
      </div>
      <div class="form-group">
        <label class="label">Price</label>
        <input type="number" step="0.01" class="form-control" name="price" v-model="price" required />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Transfer</button>
      </div>
    </form>
  </div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  data: () => ({
    sellerId: '',
    buyerId: '',
    playerId: '',
    price: ''
  }),
  methods: {
    ...mapActions([
      'TRANSFER'
    ]),
    processFormSubmit: function () {
      this.TRANSFER({
        sellerId: this.sellerId,
        buyerId: this.buyerId,
        playerId: this.playerId,
        price: parseFloat(this.price).toFixed(2),
      })
    }
  }
}
</script>