<template>
  <div class="sidebar_layout container2">
		<section class="sec_profile">
			<div class="sec_profile_head"><img :src="user.profile.avatar_url" class="sec_profile_img"></div>
			<div class="sec_profile_name">{{user.profile.firstname+user.profile.lastname}}<span>さん</span></div>
			<div class="sec_profile_btn_list">
				<button class="white_pink_btn" @click="toProfile">プロフィールの確認・編集</button>
				<button class="white_pink_btn" @click="toFavorite">お気に入りリスト</button>
				<button class="white_pink_btn" @click="toBook">参加予定のパーティー</button>
				<button class="white_pink_btn" @click="toSavedSearch">保存している検索条件</button>
				<button class="white_pink_btn" @click="toCreditCard">支払いカード情報の登録・変更</button>
			</div>
		</section>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'auth',
  layout: 'sidebar',

  metaInfo () {
    return { title: "マイページ" }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    toProfile() {
      this.$router.push({ name: 'profile' })
    },
    async logout () {
        // Log out the user.
        await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    toFavorite() {
      this.$router.push({ name: 'favorite' })
    },
    toBook() {
      this.$router.push({ name: 'book' })
    },
    toCreditCard() {
      this.$router.push({ name: 'profile.credit' })
    },
    toSavedSearch() {
      this.$router.push({ name: 'savedsearch' })
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
