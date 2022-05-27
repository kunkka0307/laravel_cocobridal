<template>
  <footer>
		<ul class="footer_menu">
			<li><a href="/search">パーティーを探す</a></li>
			<li><a href="/favorite">お気に入り一覧</a></li>
			<li><a href="/faq">よくある質問</a></li>
		</ul>
		<div class="footer_logo"><a href="/"><img src="/images/footer-logo.png"></a></div>
		<ul class="footer_sns">
			<li><a href=""><img src="/images/twitter.png"></a></li>
			<li><a href=""><img src="/images/facebook.png"></a></li>
			<li><a href=""><img src="/images/instagram.png"></a></li>
		</ul>
		<div class="copyright">Copyright © PartyParty All Rights Reserved.</div>
	</footer>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
