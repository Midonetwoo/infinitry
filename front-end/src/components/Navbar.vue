<template>
    <nav class="navbar">
      <div class="logo">
        <img src="../assets/logo.svg" alt="" />
      </div>
      <ul class="nav-menu">
        <a href="">Home</a>
        <a href="">Projects</a>
        <a href="">About</a>
        <a href="">Contact</a>
        <div v-if="isLoggedIn">
          <p>Welcome, {{ user.username }}!</p>
          <button>Log Out</button>
        </div>
        <div v-else>
          <router-link to="/login"><button>Login</button></router-link>
        </div>
        <!-- <router-view></router-view> -->
      </ul>
    </nav>
  </template>
  
  <script>
  import { mapGetters } from 'vuex'
  export default {
    name: 'Navbar',
    props: {},
    data() {
      return {}
    },
    methods: {},
    mounted() {
      console.log('Navbar mounted')
    },
    computed: {
      ...mapGetters(['isLoggedIn', 'getUser']), // Menggunakan getters dari Vuex
      user() {
        return this.getUser // Ambil informasi user dari Vuex
      },
    },
    created() {
      this.$store.dispatch('checkSession') // Memeriksa sesi saat komponen di-mount
    },
  }
  </script>
  
  <style scoped>
  .navbar {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between;
    padding: 2rem 4rem;
  }
  
  .logo img {
    height: 50px;
  }
  .nav-menu {
    display: flex;
    justify-content: space-around;
    list-style-type: none;
    gap: 20px;
  }
  button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    background-color: hsla(160, 100%, 37%, 1);
    color: white;
  }
  </style>
  