<template>
    <section class="sec_sidebar pc">
        <div class="sidebar_profile">
            <img :src="user.profile.avatar_url">
            <p class="sidebar_name">{{user.profile.firstname}}<span>さん</span></p>
            <a href="/mypage" class="to_mypage">マイページ</a>
        </div>
        <div class="sidebar_party_controls">
            <div class="sidebar_favorite" @click="toFavorite"><img src="/images/user-friends.jpg"><p>お気に入り</p></div>
				    <div class="sidebar_reserved" @click="toBook"><img src="/images/star.jpg"><p>参加予定</p></div>
        </div>
        <!-- <div class="side_bar_menu_item">検索履歴</div> -->
        <div class="side_bar_menu_item" @click="toCreditCard">支払いカード情報の登録・変更</div>
        <div class="side_bar_menu_item" @click="toSavedSearch">保存している検索条件</div>
			  <div class="side_bar_menu_item" @click="logout">ログアウト</div>
    </section>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  components: {
  },

  data: () => ({
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
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
    },
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

