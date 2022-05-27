<template>
  <div class="main-layout">
    <MainHeader />
    <div class="container mt-4">
      <child />
    </div>
    <MainFooter />
  </div>
</template>

<script>
import MainHeader from '~/components/Header'
import MainFooter from '~/components/Footer'

export default {
  name: 'MainLayout',

  components: {
    MainHeader,
    MainFooter
  }
}
</script>
