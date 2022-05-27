<template>
    <section class="sec_party_list container2" v-if="party">
		<div class="eyescatch mt2"><img v-lazy="party.eyecatch_url" /></div>
		<h3 class="party_detail_title">{{party.title}}</h3>
		<div class="party_tags" v-if="party.tags.length > 0">
			<span v-for="(tag, index) in party.tags" :key="`tag_${index}`">{{ tag.title }}</span>
		</div>
		<div class="detail_gender_infos mt2">
			<div class="detail_gender_info">
				<div class="detail_gender_img">
					<img src="/images/party_male.png"><span>男性</span>
				</div>
				<p class="detail_gender_text">年齢：  {{party.male_low_age}}歳～{{party.male_high_age}}歳</p>
				<p class="detail_gender_text">価格：  <span>{{party.male_price}}</span>円(税込)</p>
			</div>
			<div class="detail_gender_info">
				<div class="detail_gender_img">
					<img src="/images/party_female.png"><span>女性</span>
				</div>
				<p class="detail_gender_text">年齢：  {{party.female_low_age}}歳～{{party.female_high_age}}歳</p>
				<p class="detail_gender_text">価格：  <span>{{party.female_price}}</span>円(税込)</p>
			</div>
		</div>
		<div class="detail_control_btns mt3">
			<template v-if="is_future_party">
				<button class="party_register_btn" @click="reserve(party.id)" v-if="can_reserve()"><img src="/images/calendar_icon.png">予約ボタン</button>
				<button class="party_register_btn" v-else><img src="/images/calendar_icon.png">予約済み</button>
			</template>
			<button v-if="!is_favorite" class="party_favorite_btn ml-3" @click="favourite(party.id)"><img src="/images/star_white.png">お気に入りに登録する</button>
			<button v-else class="party_favorite_btn ml-3" @click="favourite(party.id)"><img src="/images/star_white.png">お気に入りから削除する</button>
		</div>
		<div class="party_detail_content mt4" v-html="party.content">
		</div>
		<div v-if="party.books.length > 0" class="party_aite_list">
			<p class="party_aite_list_title">現在申込中の相手方</p>
			<ul class="party_aites">
				<li class="party_aite" v-for="(book, index) in other_books()" :key="index"><img v-lazy="book.user.profile.avatar_url"><p>{{ book.user.user_name }}</p></li>
			</ul>
		</div>
		<div class="party_flows" v-if="party.flows.length > 0">
			<div class="party_subtitle">
				<img src="/images/glass-cheers.png"><span> 当日の流れ</span>
			</div>
			<div class="party_flows_table" v-for="(flow, index) in party.flows" :key="index">
				<div class="party_flows_row">
					<div class="party_flow_time">{{ flow.start_time }}〜</div>
					<div class="party_flow_text">
						<h4 class="party_flow_title">{{ flow.title }}</h4>
						<p v-html="flow.comment" class="pre-wrap"></p>
					</div>
				</div>
			</div>
		</div>
		<div class="party_room">
			<div class="party_subtitle">
				<img src="/images/room_map.png"><span> 開催場所</span>
			</div>
			<div class="room_info">
				{{party.room.address}}<br/>{{party.room.access}}<br/>〒{{party.room.zipcode}}
			</div>
			<div class="room_map">
				<iframe :src="'https://maps.google.com/maps?q=' + party.room.lat + ', '+ party.room.lang +'&z=15&output=embed'" width="100%" height="100%" frameborder="0" style="border:0"></iframe>
			</div>
			<div class="room_images" v-if="party.room.images.length > 0">
				<carousel
				:per-page="1"
				:autoplay="true"
				:navigation-enabled="true"
				:paginationEnabled="false"
				navigation-prev-label=""
				navigation-next-label=""
				:speed="1000"
				:loop="true">
					<slide v-for="(image, index) in party.room.images" :key="index">
						<img v-lazy="image.image_url">
					</slide>
				</carousel>
			</div>
		</div>
	</section>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import { Carousel, Slide } from 'vue-carousel'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  components: {
    Carousel,
    Slide
  },

  metaInfo () {
    return { title: this.party.title }
  },
  created () {
	this.initialize()
  },

  data: () => ({
    party: ''
  }),

  methods: {
   async initialize() {
	   const { data } = await axios.post(`/api/party/${this.$route.params.id}`);
	   this.party = data.party
	   if (this.party.flows) {
		   this.party.flows = JSON.parse(this.party.flows)
	   } else {
		   this.party.flows = []
	   }
   },
   reserve(id) {
		if(!this.user) {
			Swal.fire({
				type: 'error',
				title: "",
				text: "ログインが必要です。",
				reverseButtons: true,
				confirmButtonText: i18n.t('確認'),
				cancelButtonText: i18n.t('cancel')
			})
	   } else {
			this.$router.push({ name: 'reserve', params: { id: this.party.id } })
	   }
   },
   favourite(id) {
	   if(!this.user) {
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
				party_id: id
			})

			if (this.is_favorite) {
				this.user.favorites = this.user.favorites.filter(item => item.id != id)
			
				Swal.fire({
					icon: 'success',
					title: "",
					text: "お気に入りから削除しました。",
					reverseButtons: true,
					confirmButtonText: i18n.t('確認'),
					cancelButtonText: i18n.t('cancel')
				})
			} else {
				this.user.favorites.push(this.party)
			
				Swal.fire({
					icon: 'success',
					title: "",
					text: "お気に入りに登録しました。",
					reverseButtons: true,
					confirmButtonText: i18n.t('確認'),
					cancelButtonText: i18n.t('cancel')
				})
			}
	   }
	},
	can_reserve() {
		if (!this.user) return true;
		return this.party.books.filter(book => book.user_id == this.user.id && book.status == 1).length == 0
	},
	other_books() {
		if (!this.user) return this.party.books;
		return this.party.books.filter(book => book.user_id != this.user.id)
	}
  },
	computed: {
		...mapGetters({
			user: 'auth/user',
		}),
		is_favorite() {
			if (!this.user) return false
			if (!this.party) return false
			return this.user.favorites.filter(item => item.id == this.party.id).length > 0
		},
		is_future_party() {
			if (!this.party) return false
			let open_time = moment(`${this.party.open_date} ${this.party.open_time}`)

			return moment().diff(open_time, 'minutes') < 0
		}
	}
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
