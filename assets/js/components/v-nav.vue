<template>
  <nav>
    <ul>
      <li><a :class="{'active': this.$route.path === '/'}" href="#/">Teams</a></li>
      <li><a :class="{'active': this.$route.path === '/transfer'}" href="#/transfer">Transfers</a></li>
      <li><a :class="{'active': this.$route.path === '/add-team'}" href="#/add-team">Add team</a></li>
      <li><a :class="{'active': this.$route.path === '/add-player'}" href="#/add-player">Add player</a></li>
    </ul>
  </nav>
</template>


<style>
nav {
  text-align: center;
  display: block;
  background-color: #000;
  box-shadow: 1px 1px 5px rgba(0,0,0,.5);
  margin-bottom: 20px;
}
nav ul{
  list-style-type: none;
  display: inline-block;
  margin: 0;
}
nav ul li {
  text-align: center;
  float: left;
  margin-bottom: -6px;
}
nav ul li a {
  text-decoration: none;
  display: inline-block;
  padding: 15px 30px;
  color: #fff;
  outline:none;
}
nav ul li a:hover, nav ul li a.active {
  background-color: #fff;
  color: #000;
  border: solid #000;
  border-width: 0 .5px;
}
</style>