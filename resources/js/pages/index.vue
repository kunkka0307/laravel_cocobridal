<template>
  <section class="sec_party_list container">
		<div class="index_slider">
			<carousel
			:per-page="1"
			:autoplay="false"
			:navigation-enabled="true"
			:paginationEnabled="false"
			navigation-prev-label=""
			navigation-next-label=""
			:speed="1000"
			:loop="true">
				<slide v-for="(top, index) in topParties" :key="index">
					<img v-lazy="top.eyecatch" :alt="top.title">
				</slide>
			</carousel>
		</div>
		<div class="title">
			<p class="title_jp">＼ 開催近間の婚活パーティー ／</p>
			<p class="title_en">Latest Party</p>
		</div>
		<div class="party_list">
			<div class="party_week_days">
				<ul class="party_week_days_list">
					<li @click="weekDayActivate(0)" :class="{ active : active_el == 0 }">すべて<br/>{{filteredPartys[0].length}}件</li>
					<li @click="weekDayActivate(1)" :class="{ active : active_el == 1 }">{{ day_label(0) }}{{ weekday_label(0) }}<br/>{{filteredPartys[1].length}}件</li>
					<li @click="weekDayActivate(2)" :class="{ active : active_el == 2 }">{{ day_label(1) }}{{ weekday_label(1) }}<br/>{{filteredPartys[2].length}}件</li>
					<li @click="weekDayActivate(3)" :class="{ active : active_el == 3 }">{{ day_label(2) }}{{ weekday_label(2) }}<br/>{{filteredPartys[3].length}}件</li>
					<li @click="weekDayActivate(4)" :class="{ active : active_el == 4 }">{{ day_label(3) }}{{ weekday_label(3) }}<br/>{{filteredPartys[4].length}}件</li>
					<li @click="weekDayActivate(5)" :class="{ active : active_el == 5 }">{{ day_label(4) }}{{ weekday_label(4) }}<br/>{{filteredPartys[5].length}}件</li>
					<li @click="weekDayActivate(6)" :class="{ active : active_el == 6 }">{{ day_label(5) }}{{ weekday_label(5) }}<br/>{{filteredPartys[6].length}}件</li>
					<li @click="weekDayActivate(7)" :class="{ active : active_el == 7 }">{{ day_label(6) }}{{ weekday_label(6) }}<br/>{{filteredPartys[7].length}}件</li>
				</ul>
			</div>
			<div class="party_items">
				<div class="party_item" v-for="(party, index) in filteredParty" :key="index" @click="toPartyDetail(party.id)">
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
			<!-- <div class="party_pagination">
				<ul>
					<li v-for="index in 5" :key="index" @click="pgActive(index)" :class="{ active : active_pg == index }">{{index}}</li>
				</ul>
			</div> -->
		</div>
	</section>
</template>

<script>
import Form from 'vform'
import { Carousel, Slide } from 'vue-carousel'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'
import helper from '~/plugins/helper'
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  components: {
    Carousel,
    Slide
  },

  metaInfo () {
    return { title: 'CocoBridel' }
  },
  mounted() {
	// this.$store.dispatch('admin/fetchStudents');
  },
  created () {
	this.initialize()
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
		remember: false,
		active_el:'',
		active_pg:1,
		weekFirstDay:'',
		currentMonth:'',
		filteredPartys: [[],[],[],[],[],[],[],[]],
		partys:[],
		topParties: [],
		weekDays: ['日', '月', '火', '水', '木', '金', '土']
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
    weekDayActivate:function(el){
			this.active_el = el;
		},
		pgActive(pg) {
			this.active_pg = pg
		},
		toPartyDetail(id) {
			this.$router.push({ name: 'party', params: { id: id } })
		},
		async initialize() {
			var curr = new Date; // get current date
			this.first = curr.getDate()
			this.currentMonth = ("0" + (curr.getMonth() + 1)).slice(-2);
			var currentYear = curr.getFullYear();
			await axios.post('/api/getRecentPartys')
					.then(response => {
					this.partys = response.data.partys;
					this.topParties = response.data.top;
					
					this.filteredPartys[0] = this.partys;
					for (let i = 1; i <= 7; i++) {
						let day = ("0" + (this.first + i - 1)).slice(-2);
						let date = `${currentYear}-${this.currentMonth}-${day}`
						this.filteredPartys[i] = this.partys.filter(item=> item.open_date == date);
					}
					this.active_el = 0
				}).finally(() => {
				//   this.$store.dispatch('admin/toggleLoading', false);
			})
		},
		day_label(plus) {
			plus = ("0" + (this.first + plus)).slice(-2)
			return `${this.currentMonth}/${plus}`
		},
		weekday_label(plus) {
			var curr = new Date; // get current date

			return this.weekDays[(curr.getDay() + plus) % 7]
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
					type: 'error',
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
		filteredParty(){
			return this.filteredPartys[this.active_el];
		},
		...mapGetters({
			user: 'auth/user',
		}),
	},

}
</script>
<style>
.VueCarousel-navigation-button::before {
   	content: "";
	position: absolute;
	top: -20px;
	height: 60px;
	width: 40px;
}
.VueCarousel-navigation-next::before {
	background: url(/images/navigation-left.png?801a69a…);
    right: 16px;
    background-repeat: no-repeat;
    background-size: contain;
}
.VueCarousel-navigation-next {
	outline: none !important;
}
.VueCarousel-navigation-prev {
	outline: none !important;
}
.VueCarousel-navigation-prev::before {
	background: url('/images/navigation-right.png');
	left: 16px;
}
</style>