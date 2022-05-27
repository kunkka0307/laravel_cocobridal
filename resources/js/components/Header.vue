<template>
  <header>
		<div class="container header">
			<a href="/"><img src="/images/logo.png" class="header_logo"></a>
			<ul class="header_menu pc">
				<li><a href="/search"><img src="/images/search.png"><span>パーティーを探す</span></a></li>
				<li><a href="/favorite"><img src="/images/star.png"><span>お気に入り一覧</span></a></li>
        <li @click.prevent="logout" v-if="user" style="cursor:pointer">ログアウト</li>
        <li class="header_register" v-if="user"><a href="/mypage"><img class="header_avatar" :src="user.profile.avatar_url"><span style="padding-top: 1rem;
    display: inline-block;">　{{user.profile.firstname}}さん</span></a></li>
        <li class="header_register" v-if="!user"><a href="/register"><img src="/images/user-circle.png"><br/><span>新規登録</span></a></li>
        <li class="header_register" v-if="!user"><a href="/login"><img src="/images/sign-in-alt.png"><br/><span>ログイン</span></a></li>
			</ul>
      <div class="header_menu_sp sp">
        <ul>
          <li><a href="/search"><img src="/images/search.png"><span>パーティーを探す</span></a></li>
          <li><a href="/favorite"><img src="/images/star.png"><span>お気に入り一覧</span></a></li>
          <li class="header_register" @click.prevent="logout" v-if="user">ログアウト</li>
          <li class="header_register" v-if="!user"><a href="/register"><img src="/images/user-circle.png"><br/><span>新規登録</span></a></li>
          <li class="header_register" v-if="!user"><a href="/login"><img src="/images/sign-in-alt.png"><br/><span>ログイン</span></a></li>
        </ul>
      </div>
		</div>
	</header>
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
.header_menu_sp {
  display: none;
}
.header_register {
  cursor: pointer;
}
.header_avatar {
  width: 4rem;
  border-radius: 50%;
}
</style>
