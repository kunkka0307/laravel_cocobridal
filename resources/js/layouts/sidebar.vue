<template>
  <div class="main-layout">
    <MainHeader />
    <div class="container mt-4">
      <div class="sidebar_layout container">
        <SideBar />
        <child />
      </div>  
    </div>
    <MainFooter />
  </div>
</template>

<script>
import MainHeader from '~/components/Header'
import MainFooter from '~/components/Footer'
import SideBar from '~/components/SideBar'

export default {
  name: 'SidebarLayout',

  components: {
    MainHeader,
    MainFooter,
    SideBar

  }
}
</script>
