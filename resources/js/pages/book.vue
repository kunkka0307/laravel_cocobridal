<template>		
	<section class="sec_favorite_list container2" v-if="parties">
		<h2 class="favorite_title"><img src="/images/star_black.png">参加予定のパーティー</h2>
		<div v-if="parties.length == 0" class="text-gray text-center">参加予定のパーティーはありません。</div>
		<div v-else class="favorite_list">
			<div class="party_item" v-for="(party, index) in parties" :key="index" @click="toPartyDetail(party.id)">
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
                <div class="book_btns" v-if="is_future_party(party)">
                    <a href="javascript:void(0);" @click="event => cancelReservation(event, party)">キャンセル</a>
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
    return { title: '参加予定のパーティー' }
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
    parties: undefined
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
        async initialize() {
            const { data } = await axios.post(`/api/books`);
            this.parties = data.parties
        },
        toPartyDetail(id) {
            this.$router.push({ name: 'party', params: { id: id } })
        },
        is_favorite(party) {
            if (!this.user) return false;
            return this.user.favorites.filter(item => item.id == party.id).length > 0
        },
		is_future_party(party) {
			let open_time = moment(`${party.open_date} ${party.open_time}`)

			return moment().diff(open_time, 'minutes') < 0
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
        },
        cancelReservation(event, party) {
            event.preventDefault();
            event.stopPropagation();

            let self = this

            Swal.fire({
                title: "キャンセル確認",
                text: "この予定をキャンセルしてもよろしいでしょうか？",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: '#F63876',
                confirmButtonText: 'はい',
                cancelButtonText: "いいえ",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(async function(response) {
                if (response.isConfirmed) {
                    const { data } = await axios.post('/api/reserve/cancel', {
                        party_id: party.id
                    })
                    if (data.status == 'success') {
                        self.parties = data.parties
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: "",
                            text: "キャンセルに失敗しました。",
                            reverseButtons: true,
                            confirmButtonText: i18n.t('確認'),
                            cancelButtonText: i18n.t('cancel')
                        })
                    }
                }
            });
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
