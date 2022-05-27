<template>		
	<section class="sec_favorite_list container2" v-if="user">
		<h2 class="favorite_title"><img src="/images/star_black.png">お気に入りリスト</h2>
		<div v-if="user.favorites.length == 0" class="text-gray text-center">お気に入りリストはありません。</div>
		<div v-else class="favorite_list">
			<div class="party_item" v-for="(party, index) in user.favorites" :key="index" @click="toPartyDetail(party.id)">
				<div><img v-lazy="party.eyecatch_url" class="party_item_img"></div>
				<div class="party_meta">
					<div><img src="/images/clock.png"><span>{{party.open_date | date_month_day}}(日){{party.open_time | time_h_m}} ~ {{party.close_time | time_h_m}}</span></div>
					<div><img src="/images/map-marker-alt.png"><span>{{ party.room ? party.room.address : '' }}</span></div>
					<div v-if="is_favorite(party)" @click="event => toggleFavorite(event, party)"><img src="/images/favorite_y_star.png" class="favorite-icon"></div>
					<div v-else @click="event => toggleFavorite(event, party)"><img src="/images/favorite_n_star.png" class="favorite-icon"></div>
				</div>
				<div class="party_title" v-html="party.title"></div>
				<div class="gender_meta">
					<div class="party_male party_gender">
						<img src="/images/party_male.png">
						<div>{{party.male_low_age}}歳～{{party.male_high_age}}歳<br/><span class="pink">残り{{ party.remaining_male_seat }}席</span></div>
					</div>
					<div class="party_female party_gender">
						<img src="/images/party_female.png">
						<div>{{party.female_low_age}}歳～{{party.female_high_age}}歳<br/><span class="blue">残り{{ party.remaining_female_seat }}席</span></div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'auth',
  layout: 'sidebar',

  metaInfo () {
    return { title: 'お気に入りリスト' }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
	}),
	
  filters: {
    date_month_day(value) {
      if (value) return moment(value).format("MM/DD")
		},
		time_h_m(value) {
			if (value) return value.substring(0, 5)
		},
  },

  methods: {
    toPartyDetail(id) {
      this.$router.push({ name: 'party', params: { id: id } })
		},
		is_favorite(party) {
			if (!this.user) return false;
			return this.user.favorites.filter(item => item.id == party.id).length > 0
		},
		toggleFavorite(event, party) {
			event.preventDefault();
			event.stopPropagation();
			if (!this.user) {
				Swal.fire({
					icon: 'error',
					title: "",
					text: "ログインが必要です。",
					reverseButtons: true,
					confirmButtonText: i18n.t('確認'),
					cancelButtonText: i18n.t('cancel')
				})
			} else {
				axios.post('/api/toggle/favorite', {
					party_id: party.id
				})

				if (this.is_favorite(party)) {
					this.user.favorites = this.user.favorites.filter(item => item.id != party.id)
				} else {
					this.user.favorites.push(party)
				}
			}
		}
	},
	
	computed: {
		...mapGetters({
			user: 'auth/user',
		}),
	},
}
</script>
<style>
.party_item:nth-child(3n) {
    margin-right: 2rem;
}
.party_item:nth-child(2n) {
    margin-right: 0;
}
</style>
