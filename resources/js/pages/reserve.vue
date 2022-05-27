<template>
    <section class="sec_reserve container3">
		<h3 class="sec_title">パーティー参加予約</h3>
		<div class="reserve_friends_box">
			<div class="input_div small_select">
				<label>ご友人人数</label>
				<select class="input" v-model="friend_count" @change="updateFriends">
					<option v-for="index in max_limit" :key="index - 1">{{index - 1}}</option>
				</select>
			</div>
			<div class="reserve_friend" v-for="(friend, index) in friends" :key="index">
				<div class="friend_title">ご友人{{ index + 1 }}</div>
				<div class="name_input">
					<input class="input" type="text" v-model="friend.first_name" placeholder="姓">
					<input class="input" type="text" v-model="friend.last_name" placeholder="名">
					<input class="input" type="text" v-model="friend.first_name_kana" placeholder="せい">
					<input class="input" type="text" v-model="friend.last_name_kana" placeholder="めい">
				</div>
				<div class="gender_input input_div">
					<input type="radio" v-model="friend.gender" value="male" :id="`gender_male_${index}`"><label class="radio_label" :for="`gender_male_${index}`">男性</label>
					<input type="radio" v-model="friend.gender" value="female" :id="`gender_female_${index}`"><label class="radio_label" :for="`gender_female_${index}`">女性</label>
				</div>
				<div class="input_div small_select">
					<label>年齢</label>
					<select class="input" v-model="friend.age">
						<option v-for="index in 50" :key="index">{{ index + 17 }}</option>
					</select>
				</div>
			</div>
		</div>
		<div class="reserve_card_box">
			<div class="input_div">
				<div><label class="card_label">価格：{{ price | number }}円</label></div>
				<div><label class="card_label">参加人数：{{ (1 + this.friends.length) | number }}人</label></div>
				<div><label class="card_label">合計：{{ (1 + this.friends.length) * price | number }}円</label></div>
			</div>

			<!-- <div class="input_div">
				<div id="card-container"></div>
			</div> -->
			<div class="input_div">
				<label class="card_label">カード番号</label>
				<input type="text" class="input input_full_width" id="sq-card-number" placeholder="カード番号">
			</div>
			<div class="birthday_input input_div">
				<label>カード有効期限</label>
				<div>
					<input type="text" class="input input_full_width" id="sq-expiration-date" placeholder="カード有効期限">
				</div>
			</div>
			<div class="input_div">
				<label class="card_label">セキュリティコード</label>
				<input type="text" class="input input_full_width" id="sq-cvv" placeholder="CVV">
			</div>
			<!-- <div class="input_div">
				<label class="card_label">Postal</label>
				<input type="text" class="input input_full_width" id="sq-postal-code" placeholder="Postal">
			</div> -->
			<div class="input_div">
				<label class="card_label">カード名義</label>
				<input type="text" class="input input_full_width" placeholder="カード名義">
			</div>
		</div>
		<div class="submit_btn mt4">
			<button type="button" class="party_register_btn party_reserve_btn" @click="reserve"><img src="/images/calendar_icon.png"> 予約する</button>
		</div>
	</section>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('login') }
	},
	
	created() {
		this.initialize()
	},

	mounted() {
		// this.includeSquare('https://js.squareupsandbox.com/v2/paymentform', function() {
		// 	this.initSquare()
		// }.bind(this));

		// this.includeSquare('https://sandbox.web.squarecdn.com/v1/square.js', function() {
		// 	this.initSquare()
		// }.bind(this));
	},

  data: () => ({
    form: new Form({
		party_id: 0,
		amount: 0,
		friends: []
    }),
    remember: false,
    friend_count: 0,
	party: '',
	friends: [],
	price: 0,
	max_limit: 0
  }),

  methods: {
   async initialize() {
		const { data } = await axios.post(`/api/party/${this.$route.params.id}`);
		if (data.party) {
			this.party = data.party
			this.price = this.user.gender == 'male' ? this.party.male_price : this.party.female_price
			if (this.party.books.filter(book => book.user_id == this.user.id && book.status == 1).length > 0) this.$router.push({ name: 'party', params: { id: this.party.id } })

			this.max_limit = this.user.profile.gender == 'male' ? this.party.remaining_male_seat : this.party.remaining_female_seat

			if (this.max_limit <= 0) this.$router.push({ name: 'party', params: { id: this.party.id } })
		} else {
			this.$router.push({ name: 'index' })
		}
   },
   includeSquare(url, callback) {
	   let documentTag = document, tag = 'script',
	   		object = documentTag.createElement(tag),
			scriptTag = documentTag.getElementsByTagName(tag)[0];
		object.src = url;
		if (callback) { object.addEventListener('load', function (e) { callback(null, e); }, false); }
		scriptTag.parentNode.insertBefore(object, scriptTag);
   },
   async initializeCard(payments) {
		const card = await payments.card();
		await card.attach('#card-container'); 
		return card; 
	},
   async initSquare() {
	   const appId = SQUARE_APPLICATION_ID
	   const locationId = SQUARE_LOCATION_ID
	   if (!window.Square) {
			throw new Error('Square.js failed to load properly');
		}
		const payments = window.Square.payments(appId, locationId);
		let card;
		try {
			card = await this.initializeCard(payments);
		} catch (e) {
			console.error('Initializing Card failed', e);
			return;
		}
	    // const paymentForm = new SqPaymentForm({
		// 	// Initialize the payment form elements

		// 	//TODO: Replace with your sandbox application ID
		// 	applicationId: SQUARE_APPLICATION_ID,
		// 	inputClass: 'sq-input',
		// 	autoBuild: false,
		// 	// Customize the CSS for SqPaymentForm iframe elements
		// 	inputStyles: [{
		// 		fontSize: '16px',
		// 		lineHeight: '24px',
		// 		padding: '16px',
		// 		placeholderColor: '#a0a0a0',
		// 		backgroundColor: 'transparent',
		// 	}],
		// 	// Initialize the credit card placeholders
		// 	cardNumber: {
		// 		elementId: 'sq-card-number',
		// 		placeholder: 'カード番号'
		// 	},
		// 	cvv: {
		// 		elementId: 'sq-cvv',
		// 		placeholder: 'CVV'
		// 	},
		// 	expirationDate: {
		// 		elementId: 'sq-expiration-date',
		// 		placeholder: 'MM/YY'
		// 	},
		// 	postalCode: {
		// 		elementId: 'sq-postal-code',
		// 		placeholder: 'Postal'
		// 	},
		// 	// SqPaymentForm callback functions
		// 	callbacks: {
		// 		/*
		// 		* callback function: cardNonceResponseReceived
		// 		* Triggered when: SqPaymentForm completes a card payment token request
		// 		*/
		// 		cardNonceResponseReceived: function (errors, nonce, cardData, billingContact, shippingContact, shippingOption) {
		// 		if (errors) {
		// 			// Log errors from payment token generation to the browser developer console.
		// 			console.error('Encountered errors:');
		// 			errors.forEach(function (error) {
		// 				console.error('  ' + error.message);
		// 			});
		// 			alert('Encountered errors, check browser developer console for more details');
		// 				return;
		// 		}
		// 		//TODO: Replace alert with code in step 2.1
		// 		alert(`The generated payment token is:\n${nonce}`);
		// 		}
		// 	}
		// });
   },
    async login () {
      this.$router.push({ name: 'index' })
    },

    redirect () {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'home' })
      }
		},
		updateFriends() {
			if (this.friends.length > this.friend_count) {
				this.friends = this.friends.filter((item, index) => index < this.friend_count)
			} else {
				const limit = this.friend_count - this.friends.length;
				for (let i = 0; i < limit; i++) {
					this.friends.push({
						first_name: '',
						last_name: '',
						first_name_kana: '',
						last_name_kana: '',
						gender: 'male',
						age: undefined
					})
				}
			}
		},
		async reserve() {
			if (this.form.busy) return;

			this.form.amount = (1 + this.friends.length) * this.price
			this.form.friends = this.friends
			this.form.party_id = this.party.id
			const { data } = await this.form.post('/api/reserve')

			if (data.status == 'failed') {
				Swal.fire({
					type: 'error',
					icon: 'error',
					title: "",
					text: "予約できませんでした。",
					reverseButtons: true,
					confirmButtonText: i18n.t('確認'),
					cancelButtonText: i18n.t('cancel')
				})
			} else if (data.status == 'payment_failed') {
				Swal.fire({
					type: 'error',
					icon: 'error',
					title: "",
					text: "支払いにエラーが発生しました。",
					reverseButtons: true,
					confirmButtonText: i18n.t('確認'),
					cancelButtonText: i18n.t('cancel')
				})
			} else {
				// Redirect to Reservations Page
				this.$router.push({ name: 'book' })
			}
		}
  },
  computed: mapGetters({
    user: 'auth/user'
	}),
  filters: {
		number(value) {
			if (isNaN(value)) return 0;

			return new Intl.NumberFormat('en').format(value)
		}
  },
}
</script>
